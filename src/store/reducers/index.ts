import * as actions from "../actions";

const initialState: any = {
  projects: [],
  menus: {
    SiteNav: [],
    SocialMenu: [],
  },
};

const reducer = (state = initialState, action: any): void => {
  switch (action.type) {
    case actions.PROJECTS:
      return {
        ...state,
        projects: [...state.projects, action.payload],
      };
    case actions.SITENAV:
      return {
        ...state,
        menus: {
          ...state.menus,
          SiteNav: action.payload,
        },
      };
    case actions.SOCIALMENU:
      return {
        ...state,
        menus: {
          ...state.menus,
          SocialMenu: action.payload,
        },
      };
    default:
      return state;
  }
};

export default reducer;
