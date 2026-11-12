import { test } from 'node:test'
import assert from 'node:assert/strict'
import { resolveScreen, isOwnEntry } from './screen.js'

test('a fresh visit without ?r shows the intro', () => {
  assert.deepEqual(resolveScreen(null, '', 0), { step: 'intro' })
})

test('a shared link shows the friend result', () => {
  assert.deepEqual(resolveScreen(null, '?r=cfo', 0), { step: 'result', key: 'cfo', shared: true })
})

test('invalid or prototype ?r values fall back to the intro', () => {
  for (const r of ['constructor', '__proto__', 'bogus', '']) {
    assert.deepEqual(resolveScreen(null, `?r=${r}`, 0), { step: 'intro' }, r)
  }
})

test('an own result entry survives a reload as own, even with a ?r in the URL', () => {
  assert.deepEqual(resolveScreen({ r: 'host' }, '?r=host', 0), { step: 'result', key: 'host', shared: false })
})

test('a quiz entry is restored only while its answers are still in memory', () => {
  assert.deepEqual(resolveScreen({ q: 4 }, '', 4), { step: 'quiz', index: 4 })
  assert.deepEqual(resolveScreen({ q: 4 }, '', 2), { step: 'intro' })
  assert.deepEqual(resolveScreen({ q: 4 }, '?r=cfo', 0), { step: 'result', key: 'cfo', shared: true })
})

test('isOwnEntry recognises only quiz-written history states', () => {
  assert.equal(isOwnEntry(null), false)
  assert.equal(isOwnEntry({}), false)
  assert.equal(isOwnEntry({ r: 'constructor' }), false)
  assert.equal(isOwnEntry({ q: 0 }), true)
  assert.equal(isOwnEntry({ r: 'tears' }), true)
})
