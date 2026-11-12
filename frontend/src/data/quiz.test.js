import { test } from 'node:test'
import assert from 'node:assert/strict'
import { types, questions, decide, isType } from './quiz.js'

test('decide picks the single highest type', () => {
  assert.equal(decide(['cfo', 'host', 'cfo', 'tears', 'cfo']), 'cfo')
})

test('decide breaks ties by the most recent pick among tied types', () => {
  assert.equal(decide(['cfo', 'host', 'cfo', 'host', 'tears']), 'host')
  assert.equal(decide(['host', 'cfo', 'host', 'cfo']), 'cfo')
})

test('isType rejects prototype keys and unknown values', () => {
  for (const k of ['constructor', '__proto__', 'toString', 'hasOwnProperty', 'bogus', '', null, undefined]) {
    assert.equal(isType(k), false, String(k))
  }
  for (const k of Object.keys(types)) assert.equal(isType(k), true)
})

test('every question offers each type exactly once and every mate exists', () => {
  const keys = Object.keys(types).sort()
  for (const q of questions) assert.deepEqual(q.a.map((a) => a.type).sort(), keys, q.q)
  for (const t of Object.values(types)) assert.ok(isType(t.mate))
})
