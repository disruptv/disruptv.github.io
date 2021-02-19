import axios, { AxiosResponse } from "axios";
import { Action, AnyAction, Dispatch } from "redux";
import { ThunkAction as ReduxThunkAction, ThunkDispatch } from "redux-thunk";
import logger from "../../utils/logger";

type ThunkAction<ReturnType = void> = ReduxThunkAction<
  ReturnType,
  any,
  unknown,
  Action<string>
>;

const $http = axios.create({
  baseURL: process.env.REACT_APP_PROXY + "/wp/v2/",
});

export const PAGES = "PAGES";
export const getPages = (): ThunkAction => {
  return async (
    dispatch: Dispatch,
    getState: unknown
  ): Promise<AnyAction | void> => {
    try {
      const response = await $http.get("/pages");
      const payload = response.data;

      return dispatch({
        type: PAGES,
        payload,
      });
    } catch (error) {
      logger.error(error.response);
    }
  };
};

export const PROJECTS = "PROJECTS";
export const getProjects = (): ThunkAction => {
  return async (
    dispatch: Dispatch,
    getState: unknown
  ): Promise<AnyAction | void> => {
    try {
      const response = await $http.get("/posts");
      const payload = response.data;

      return dispatch({
        type: PROJECTS,
        payload,
      });
    } catch (error) {
      logger.error(error.response.data);
    }
  };
};

export const SITENAV = "SITENAV";
export const getSiteNav = (): ThunkAction => {
  return async (
    dispatch: Dispatch,
    getState: any
  ): Promise<AnyAction | void> => {
    try {
      const response = await $http.get("/menus");
      let payload: string[] = response.data["site-nav"];
      payload =
        typeof payload === "string" ? getState().menus.SiteNav : payload;

      return dispatch({
        type: SITENAV,
        payload,
      });
    } catch (error) {
      logger.error(error.response.data);
    }
  };
};

export const SOCIALMENU = "SOCIALMENU";
export const getSocialMenu = (): ThunkAction => {
  return async (
    dispatch: Dispatch,
    getState: any
  ): Promise<AnyAction | void> => {
    try {
      const response: AxiosResponse<any> = await $http.get("/menus");
      let payload: string[] = response.data["social-links"];
      payload =
        typeof payload === "string" ? getState().menus.SocialMenu : payload;

      return dispatch({
        type: SOCIALMENU,
        payload,
      });
    } catch (error) {
      logger.error(error.response.data);
    }
  };
};

export const SETTINGS = "SETTINGS";
export const getSettings = (): ThunkAction => {
  return async (
    dispatch: Dispatch,
    getState: any
  ): Promise<AnyAction | void> => {
    try {
      const response: AxiosResponse<any> = await $http.get("/settings");
      const payload = { home: 1453 }; // response.data;

      return dispatch({
        type: SETTINGS,
        payload,
      });
    } catch (error) {
      logger.error(error.response.data);
    }
  };
};

export const INITIALIZE = "INITIALIZE";
export const initialize = async (dispatch: any) => {
  await Promise.all([
    // dispatch(getSettings()),
    dispatch(getProjects()),
    dispatch(getSiteNav()),
    dispatch(getSocialMenu),
    dispatch(getPages()),
  ]);

  return dispatch(initalized());
};
const initalized = () => ({
  type: INITIALIZE,
});
