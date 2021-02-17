import { AnyAction, applyMiddleware, createStore } from "redux";
import { composeWithDevTools } from "redux-devtools-extension";
import thunk, { ThunkMiddleware } from "redux-thunk";

import rootReducer from "./reducers";
import { getProjects, getSiteNav, getSocialMenu } from "./actions";

const composedEnhancer = composeWithDevTools(
  applyMiddleware(thunk as ThunkMiddleware<unknown, AnyAction>)
);

const store = createStore(rootReducer, composedEnhancer);
store.dispatch(getProjects());
store.dispatch(getSiteNav());
// store.dispatch(getSocialMenu);

export default store;
