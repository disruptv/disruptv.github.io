import { RootStateOrAny } from "react-redux";
import { AnyAction } from "redux";

const initialState: RootStateOrAny = {
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

const reducer = (state = initialState, action: AnyAction): RootStateOrAny => {
  switch (action.type) {
    case "GET_PAGES":
      return {
        ...state,
        pages: [...state.pages, ...action.payload],
      };
    case "GET_PROJECTS":
      return {
        ...state,
        projects: action.payload,
      };
    case "GET_SITENAV":
      return {
        ...state,
        menus: {
          ...state.menus,
          SiteNav: action.payload,
        },
      };
    case "GET_SOCIALMENU":
      return {
        ...state,
        menus: {
          ...state.menus,
          SocialMenu: action.payload,
        },
      };
    case "GET_HOME_ID":
      return {
        ...state,
        settings: {
          ...state.settings,
          homeId: action.payload,
        },
      };
    case "GET_PROJECT_CAT":
      return {
        ...state,
        settings: {
          ...state.settings,
          projectCatId: action.payload,
        },
      };
    case "GET_SETTINGS":
      return {
        ...state,
      };
    case "IS_INITIALIZED":
      return {
        ...state,
        ready: true,
      };
    default:
      return state;
  }
};

export default reducer;
