import axios, { AxiosResponse } from "axios";
import { Action, AnyAction, Dispatch } from "redux";
import { ThunkAction as ReduxThunkAction, ThunkDispatch } from "redux-thunk";

type ThunkAction<ReturnType = void> = ReduxThunkAction<
  ReturnType,
  any,
  unknown,
  Action<string>
>;

const $http = axios.create({
  baseURL: `${process.env.REACT_APP_PROXY}/wp-json/wp/v2`,
});

/**
 * Load Global settings for reuse
 */

const getProjectCatId = (slug: string) => {
  return async (
    dispatch: Dispatch,
    getState: any
  ): Promise<AnyAction | void> => {
    try {
      const response = await $http.get(`/categories?slug=${slug}`);

      return dispatch({
        type: "GET_PROJECT_CAT",
        payload: response.data[0].id,
      });
    } catch (error) {
      console.error(error.response.data);
    }
  };
};

const getHomeId = (): ThunkAction => {
  return async (
    dispatch: Dispatch,
    getState: any
  ): Promise<AnyAction | void> => {
    try {
      // const response = await $http.get("/settings");
      const payload = 0; // response.data;

      return dispatch({
        type: "GET_HOME_ID",
        payload,
      });
    } catch (error) {
      console.error(error.response.data);
    }
  };
}; // TODO: Get real ID from API

export const getSettings = async (dispatch: Dispatch<any>): Promise<any> => {
  try {
    await Promise.all([
      dispatch(getHomeId()),
      dispatch(getProjectCatId("project")),
    ]);

    return dispatch({
      type: "GET_SETTINGS",
    });
  } catch (error) {
    console.error(error);
  }
};

/**
 * Load all page data
 */

export const getPages = (): ThunkAction => {
  return async (
    dispatch: Dispatch,
    getState: unknown
  ): Promise<AnyAction | void> => {
    try {
      const response = await $http.get("/pages");
      const payload = response.data;

      return dispatch({
        type: "GET_PAGES",
        payload,
      });
    } catch (error) {
      console.error(error.response);
    }
  };
};

const getPosts = async (
  catId: string | number | null = "",
  tags: string[] | string | null = ""
): Promise<any> => {
  try {
    let response;

    if (catId === "" && tags === "") {
      response = await $http.get(`/posts?per_page=100`);
    } else if (catId === "" && tags !== "") {
      response = await $http.get(`/posts?tags=${tags}&per_page=100`);
    } else if (catId !== "" && tags === "") {
      response = await $http.get(`/posts?categories=${catId}&per_page=100`);
    } else {
      response = await $http.get(
        `/posts?categories=${catId}&tags=${tags}&per_page=100`
      );
    }

    return response.data;
  } catch (error) {
    console.error(error.response.data);
  }
};

export const getProjectPosts = (): ThunkAction => {
  return async (
    dispatch: Dispatch,
    getState: any
  ): Promise<AnyAction | void> => {
    try {
      const { projectCatId } = getState().settings;
      const projects = await getPosts(projectCatId);

      return dispatch({
        type: "GET_PROJECTS",
        payload: projects,
      });
    } catch (error) {
      console.error(error);
    }
  };
};

/**
 * Get details for categories
 * @param {string|string[]} ids
 */
export const getCatsByID = async (
  ids: string | string[] = []
): Promise<any[] | void> => {
  try {
    if (ids.length !== 0) {
      const response = await $http.get(`/categories?include=${ids}`);
      return response.data;
    }
    return;
  } catch (error) {
    console.error(error);
  }
};
/**
 * Get details for tags
 * @param {string|string[]} ids
 */
export const getTagsByID = async (
  ids: string | string[] = []
): Promise<any[] | void> => {
  try {
    let response;

    if (ids.length !== 0) {
      response = await $http.get(`/tags?include=${ids}`);
    } else {
      response = await $http.get(`/tags`);
    }

    return response.data;
  } catch (error) {
    console.error(error);
  }
};

/**
 * Load Site Nav & social media links
 */

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
        type: "GET_SITENAV",
        payload,
      });
    } catch (error) {
      console.error(error.response.data);
    }
  };
};

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
        type: "GET_SOCIALMENU",
        payload,
      });
    } catch (error) {
      console.error(error.response.data);
    }
  };
};

/**
 * Notify when everything's ready
 */

export const initialize = async (
  dispatch: ThunkDispatch<any, unknown, Action<any>>
): Promise<any> => {
  try {
    await Promise.all([
      dispatch(getSettings),
      dispatch(getSiteNav()),
      dispatch(getSocialMenu()),
    ]);

    return dispatch({
      type: "IS_INITIALIZED",
    });
  } catch (error) {
    console.error(error);
  }
};
