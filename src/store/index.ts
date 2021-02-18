import { AnyAction, applyMiddleware, createStore } from "redux";
import { composeWithDevTools } from "redux-devtools-extension";
import thunk, { ThunkMiddleware } from "redux-thunk";

import rootReducer from "./reducers";

const composedEnhancer = composeWithDevTools(
  applyMiddleware(thunk as ThunkMiddleware<unknown, AnyAction>)
);

const store = createStore(rootReducer, composedEnhancer);

export default store;
