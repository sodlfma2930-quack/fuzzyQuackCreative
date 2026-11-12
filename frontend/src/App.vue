<script setup>
import { ref, computed, watch, onMounted, onUnmounted } from 'vue'
import { types, questions, decide } from './data/quiz.js'
import { resolveScreen, isOwnEntry } from './screen.js'

function shuffle(list) {
  const a = [...list]
  for (let i = a.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1))
    ;[a[i], a[j]] = [a[j], a[i]]
  }
  return a
}

// Shuffle answers so the answer position doesn't give away the type.
const shuffled = () => questions.map((q) => ({ ...q, a: shuffle(q.a) }))

const step = ref('intro')
const index = ref(0)
const picks = ref([])
const resultKey = ref(null)
const fromShare = ref(false)
const copied = ref(false)
const order = ref(shuffled())
let lastPick = 0

const current = computed(() => order.value[index.value])
const progress = computed(() => Math.round(((index.value + 1) / questions.length) * 100))
const result = computed(() => types[resultKey.value])
const mate = computed(() => types[result.value?.mate])

// Reads the live history entry, so it is correct both on load and after back/forward.
function showCurrentEntry() {
  const s = resolveScreen(history.state, location.search, picks.value.length)
  step.value = s.step
  if (s.step === 'quiz') index.value = s.index
  if (s.step === 'result') {
    resultKey.value = s.key
    fromShare.value = s.shared
  }
}

// The whole quiz lives in one history entry: one back press returns to the intro (or the friend's
// result), the next leaves the page, instead of walking back through every question.
function start() {
  order.value = shuffled()
  index.value = 0
  picks.value = []
  resultKey.value = null
  fromShare.value = false
  step.value = 'quiz'
  const write = isOwnEntry(history.state) ? 'replaceState' : 'pushState'
  history[write]({ q: 0 }, '', location.pathname)
}

function choose(type) {
  // Ignore the second tap of a fast double tap landing on the next question.
  const now = Date.now()
  if (now - lastPick < 350) return
  lastPick = now

  picks.value = [...picks.value.slice(0, index.value), type]
  if (index.value < questions.length - 1) {
    index.value++
    history.replaceState({ q: index.value }, '')
    return
  }
  const key = decide(picks.value)
  resultKey.value = key
  fromShare.value = false
  step.value = 'result'
  history.replaceState({ r: key }, '', `${location.pathname}?r=${key}`)
}

function back() {
  if (index.value === 0) return
  index.value--
  history.replaceState({ q: index.value }, '')
}

onMounted(() => window.addEventListener('popstate', showCurrentEntry))
onUnmounted(() => window.removeEventListener('popstate', showCurrentEntry))

watch([step, index], () => window.scrollTo({ top: 0 }))

showCurrentEntry()

async function share() {
  const url = `${location.origin}${location.pathname}?r=${resultKey.value}`
  const text = `나는 결혼식에서 "${result.value.name}" 래. 너는 어떤 하객이야?`
  if (navigator.share) {
    try {
      await navigator.share({ title: '나는 어떤 결혼식 하객일까?', text, url })
      return
    } catch (e) {
      if (e?.name === 'AbortError') return
      // Other failures (e.g. broken in-app browsers) fall through to the clipboard.
    }
  }
  try {
    await navigator.clipboard.writeText(`${text}\n${url}`)
    copied.value = true
    setTimeout(() => (copied.value = false), 2000)
  } catch {
    prompt('아래 링크를 복사해 주세요', url)
  }
}
</script>

<template>
  <main class="page">
    <section v-if="step === 'intro'" class="card intro">
      <p class="eyebrow">30대 하객 유형 테스트</p>
      <h1 class="title">나는 결혼식에서<br />어떤 하객일까?</h1>
      <p class="lead">
        청첩장이 쌓이는 나이, 주말마다 결혼식에 가면서<br />
        나도 모르게 생긴 습관이 있다면?
      </p>
      <div class="emoji-row" aria-hidden="true">
        <span v-for="t in types" :key="t.name">{{ t.emoji }}</span>
      </div>
      <button class="btn btn--primary" @click="start">테스트 시작하기</button>
      <p class="meta">질문 {{ questions.length }}개 · 약 1분</p>
    </section>

    <section v-else-if="step === 'quiz'" class="card quiz">
      <div class="quiz__top">
        <button class="link" :disabled="index === 0" @click="back">← 이전</button>
        <span class="count">{{ index + 1 }} / {{ questions.length }}</span>
      </div>
      <div class="bar" role="progressbar" :aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100">
        <div class="bar__fill" :style="{ width: progress + '%' }"></div>
      </div>
      <h2 class="question">{{ current.q }}</h2>
      <div class="answers">
        <button
          v-for="(a, i) in current.a"
          :key="`${index}-${i}`"
          class="answer"
          @click="choose(a.type)"
        >
          {{ a.t }}
        </button>
      </div>
    </section>

    <section v-else class="card result">
      <p class="eyebrow">{{ fromShare ? '친구의 하객 유형은' : '나의 하객 유형은' }}</p>
      <div class="result__emoji">{{ result.emoji }}</div>
      <h1 class="title">{{ result.name }}</h1>
      <p class="tagline">"{{ result.tagline }}"</p>
      <p class="desc">{{ result.desc }}</p>
      <ul class="traits">
        <li v-for="t in result.traits" :key="t">{{ t }}</li>
      </ul>
      <div class="mate">
        <span class="mate__label">찰떡 하객 메이트</span>
        <strong>{{ mate.emoji }} {{ mate.name }}</strong>
      </div>
      <div class="actions">
        <template v-if="fromShare">
          <button class="btn btn--primary" @click="start">나도 테스트하기</button>
        </template>
        <template v-else>
          <button class="btn btn--primary" @click="share">{{ copied ? '링크 복사됨!' : '친구에게 공유하기' }}</button>
          <button class="btn" @click="start">다시 하기</button>
        </template>
      </div>
    </section>
  </main>
</template>

<style scoped>
.page {
  min-height: 100vh;
  min-height: 100svh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 24px 16px;
}
.card {
  width: 100%;
  max-width: 440px;
  background: var(--card);
  border-radius: 24px;
  padding: 36px 24px;
  box-shadow: 0 12px 40px var(--shadow);
  text-align: center;
}
.eyebrow {
  font-size: 13px;
  font-weight: 500;
  color: var(--accent);
  letter-spacing: 0.04em;
  margin-bottom: 12px;
}
.title {
  font-family: 'Noto Serif KR', serif;
  font-size: 28px;
  font-weight: 600;
  line-height: 1.35;
  margin-bottom: 16px;
}
.lead {
  font-size: 15px;
  color: var(--sub);
  line-height: 1.7;
}
.emoji-row {
  display: flex;
  justify-content: center;
  gap: 12px;
  font-size: 36px;
  margin: 28px 0;
}
.meta {
  margin-top: 12px;
  font-size: 13px;
  color: var(--sub);
}
.btn {
  width: 100%;
  padding: 16px;
  border-radius: 14px;
  border: 1px solid var(--line);
  background: transparent;
  color: var(--text);
  font: inherit;
  font-size: 16px;
  font-weight: 500;
  cursor: pointer;
  transition: transform 0.15s, background 0.15s;
}
.btn:active {
  transform: scale(0.98);
}
.btn--primary {
  background: var(--accent);
  border-color: var(--accent);
  color: var(--on-accent);
}
.quiz {
  text-align: left;
}
.quiz__top {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 12px;
}
.link {
  background: none;
  border: none;
  color: var(--sub);
  font: inherit;
  font-size: 14px;
  cursor: pointer;
  padding: 4px 0;
}
.link:disabled {
  visibility: hidden;
}
.count {
  font-size: 14px;
  font-weight: 500;
  color: var(--accent);
}
.bar {
  height: 6px;
  background: var(--line);
  border-radius: 99px;
  overflow: hidden;
  margin-bottom: 28px;
}
.bar__fill {
  height: 100%;
  background: var(--accent);
  border-radius: 99px;
  transition: width 0.3s ease;
}
.question {
  font-size: 20px;
  font-weight: 600;
  line-height: 1.5;
  margin-bottom: 24px;
  word-break: keep-all;
}
.answers {
  display: flex;
  flex-direction: column;
  gap: 10px;
}
.answer {
  text-align: left;
  padding: 16px 18px;
  border-radius: 14px;
  border: 1px solid var(--line);
  background: var(--bg);
  color: var(--text);
  font: inherit;
  font-size: 15px;
  line-height: 1.5;
  word-break: keep-all;
  cursor: pointer;
  transition: border-color 0.15s, background 0.15s;
}
.answer:hover,
.answer:focus-visible {
  border-color: var(--accent);
  background: var(--accent-soft);
  outline: none;
}
.result__emoji {
  font-size: 72px;
  line-height: 1;
  margin-bottom: 12px;
}
.tagline {
  font-size: 15px;
  color: var(--accent);
  font-weight: 500;
  margin-bottom: 20px;
}
.desc {
  font-size: 15px;
  line-height: 1.8;
  color: var(--text);
  text-align: left;
  word-break: keep-all;
  margin-bottom: 20px;
}
.traits {
  list-style: none;
  text-align: left;
  background: var(--bg);
  border-radius: 14px;
  padding: 16px 18px;
  margin-bottom: 16px;
}
.traits li {
  font-size: 14px;
  line-height: 1.6;
  padding-left: 18px;
  position: relative;
  word-break: keep-all;
}
.traits li + li {
  margin-top: 8px;
}
.traits li::before {
  content: '✓';
  position: absolute;
  left: 0;
  color: var(--accent);
}
.mate {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border: 1px dashed var(--line);
  border-radius: 14px;
  padding: 14px 18px;
  margin-bottom: 24px;
  font-size: 15px;
}
.mate__label {
  font-size: 13px;
  color: var(--sub);
}
.actions {
  display: flex;
  flex-direction: column;
  gap: 10px;
}
</style>
