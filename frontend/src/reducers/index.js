import { combineReducers } from 'redux'

const initializedState = {
  entities: {},
  result: [],
  lastUpdated: null
}

const images = (state = initializedState, action) => {
  switch (action.type) {
    default:
      return state
  }
}

const reducer = combineReducers({
  images
})

export default reducer
