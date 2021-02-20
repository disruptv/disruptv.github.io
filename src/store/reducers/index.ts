import { AnyAction } from "redux";
import * as actions from "../actions";

const initialState: any = {
  pages: [],
  projects: [],
  menus: {
    SiteNav: [
      {
        url: "",
        title: "",
      },
    ],
    SocialMenu: [
      {
        url: "",
        title: "",
      },
    ],
  },
  settings: {
    homeId: 0,
    projectCatId: 0,
  },
  ready: false,
};

const reducer = (state = initialState, action: AnyAction): void => {
  switch (action.type) {
    case actions.GET_PAGES:
      return {
        ...state,
        pages: [...state.pages, ...action.payload],
      };
    case actions.GET_PROJECTS:
      return {
        ...state,
        projects: action.payload,
      };
    case actions.GET_SITENAV:
      return {
        ...state,
        menus: {
          ...state.menus,
          SiteNav: action.payload,
        },
      };
    case actions.GET_SOCIALMENU:
      return {
        ...state,
        menus: {
          ...state.menus,
          SocialMenu: action.payload,
        },
      };
    case actions.GET_HOME_ID:
      return {
        ...state,
        settings: {
          ...state.settings,
          homeId: action.payload,
        },
      };
    case actions.GET_PROJECT_CAT:
      return {
        ...state,
        settings: {
          ...state.settings,
          projectCatId: action.payload,
        },
      };
    case actions.GET_SETTINGS:
      return {
        ...state,
      };
    case actions.IS_INITIALIZED:
      return {
        ...state,
        ready: true,
      };
    default:
      return state;
  }
};

export default reducer;
