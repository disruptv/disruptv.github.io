import * as actions from "../actions";

const initialState: any = {
  pages: [],
  projects: [],
  menus: {
    SiteNav: [
      {
        url: "#",
        title: "Projects",
      },
      {
        url: "#",
        title: "About",
      },
      {
        url: "#",
        title: "Resume",
      },
    ],
    SocialMenu: [
      {
        url: "https://linkedin.com/in/aaronsalley",
        title: "LinkedIn",
      },
      {
        url: "https://github.com/aaronsalley",
        title: "Github",
      },
      {
        url: "https://www.figma.com/@disruptv",
        title: "Figma",
      },
      {
        url: "https://www.instagram.com/aaronsalleyhim/",
        title: "Instagram",
      },
      {
        url: "https://twitter.com/aaronsalley",
        title: "Twitter",
      },
    ],
  },
  settings: {
    home: 0,
  },
  ready: false,
};

const reducer = (state = initialState, action: any): void => {
  switch (action.type) {
    case actions.PAGES:
      return {
        ...state,
        pages: [...state.pages, ...action.payload],
      };
    case actions.PROJECTS:
      return {
        ...state,
        projects: action.payload,
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
    case actions.SETTINGS:
      return {
        ...state,
        settings: action.payload,
      };
    case actions.INITIALIZE:
      return {
        ...state,
        ready: true,
      };
    default:
      return state;
  }
};

export default reducer;
