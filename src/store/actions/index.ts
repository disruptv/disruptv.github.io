import axios from "axios";
import { Action, AnyAction, Dispatch } from "redux";
import { ThunkAction as ReduxThunkAction } from "redux-thunk";

type ThunkAction<ReturnType = void> = ReduxThunkAction<
  ReturnType,
  any,
  unknown,
  Action<string>
>;

const $http = axios.create({
  baseURL: "?rest_route=/wp/v2/",
});

export const HOME = "HOME";
export const getHome = (): ThunkAction => {
  return async (dispatch: Dispatch, getState: unknown): Promise<AnyAction> => {
    const response = await $http.get("/posts");

    return dispatch({
      type: HOME,
      payload: response.data,
    });
  };
};

export const PROJECTS = "PROJECTS";
export const getProjects = (): ThunkAction => {
  return async (dispatch: Dispatch, getState: unknown): Promise<AnyAction> => {
    const response = await $http.get("/posts");

    return dispatch({
      type: PROJECTS,
      payload: response.data,
    });
  };
};

export const SITENAV = "SITENAV";
export const getSiteNav = (): ThunkAction => {
  return async (dispatch: Dispatch, getState: unknown): Promise<AnyAction> => {
    const response = await $http.get("/menus");

    return dispatch({
      type: SITENAV,
      payload: response.data["site-nav"],
    });
  };
};

export const SOCIALMENU = "SOCIALMENU";
export const getSocialMenu = async (
  dispatch: Dispatch,
  getState: unknown
): Promise<AnyAction> => {
  const response = await $http.get("/menus");

  return dispatch({
    type: SOCIALMENU,
    payload: response.data["social-links"],
  });
};
