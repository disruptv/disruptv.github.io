import * as actions from "../actions";

const initialState: any = {
  home: {
    title: `I work with startups and top companies on intentional, 
    radical, innovative digital solutions.`,
    excerpt: `I'm Aaron. Having careers in the arts and tech, my 
    philosophy leverages connections between diverse experiences.</br> 
    I draw from human-centered yet pragmatic technical skills to 
    bring conscientiousness, creativity, and strategic thinking to all that I do.</br> 
    Over the last decade, I've worked with startups and established companies alike
    — taking ideas from mind to market.`,
  },
  projects: [],
  menus: {
    SiteNav: [],
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
};

const reducer = (state = initialState, action: any): void => {
  switch (action.type) {
    case actions.HOME:
      return {
        ...state,
        home: action.payload,
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
    default:
      return state;
  }
};

export default reducer;
