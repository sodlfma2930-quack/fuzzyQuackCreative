import { isType } from './data/quiz.js'

// Decides which screen a history entry shows; a quiz entry whose answers were lost to a reload falls back to the intro.
export function resolveScreen(state, search, picksLength) {
  if (state && Number.isInteger(state.q) && state.q >= 0 && state.q <= picksLength) {
    return { step: 'quiz', index: state.q }
  }
  if (isType(state?.r)) return { step: 'result', key: state.r, shared: false }
  const shared = new URLSearchParams(search).get('r')
  if (isType(shared)) return { step: 'result', key: shared, shared: true }
  return { step: 'intro' }
}

// True when the current history entry was written by the quiz, so it can be replaced instead of stacked.
export function isOwnEntry(state) {
  return Boolean(state) && (Number.isInteger(state.q) || isType(state.r))
}
