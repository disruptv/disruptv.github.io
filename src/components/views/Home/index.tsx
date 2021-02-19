import React from "react";
import { connect } from "react-redux";
import stripHTML from "../../../utils/stripHTML";
import ProjectSlate from "../../molecules/ProjectSlate";
import styles from "./index.module.scss";

const mapStateToProps = (state: any, ownProps: any) => {
  const { projects, pages, settings, ready } = state;

  return {
    projects,
    pages,
    settings,
    ready,
  };
};

class Home extends React.Component<any, any> {
  constructor(props: any) {
    super(props);

    this.state = {
      id: 0,
      title: `I work with startups and top companies on intentional, 
      radical, innovative digital solutions.`,
      excerpt: `I'm Aaron. Having careers in the arts and tech, my 
      philosophy leverages connections between diverse experiences.</br> 
      I draw from human-centered yet pragmatic technical skills to 
      bring conscientiousness, creativity, and strategic thinking to all that I do.</br> 
      Over the last decade, I've worked with startups and established companies alike
      — taking ideas from mind to market.`,
    };
  }

  componentDidMount() {
    this.selectHomeFromPages();
  }

  componentDidUpdate(prevProps: any) {
    if (prevProps.pages !== this.props.pages) {
      this.selectHomeFromPages();
    }
  }

  selectHomeFromPages = () => {
    const content = this.props.pages
      .filter(
        (page: any) =>
          this.props.settings.home !== 0 && page.id === this.props.settings.home
      )
      .pop();

    if (content) {
      this.setState({
        title: stripHTML(content.title.rendered),
        excerpt: stripHTML(content.excerpt.rendered),
      });
    }

    return false;
  };

  composeIntro = () => {
    return this.state.excerpt.split("</br>").map((p: string, i: number) => {
      return <p key={i}>{p}</p>;
    });
  };

  composeProjects = () => {
    return this.props.projects.map((project: any, i: number) => {
      return <ProjectSlate {...project} key={i} />;
    });
  };

  render() {
    return (
      <main className={styles.container}>
        <section className={styles.Section__intro}>
          <h1>
            <small>Hey there,</small>
            {this.state.title}
          </h1>
          <div className={styles.intro}>{<this.composeIntro />}</div>
        </section>
        <section className={styles.Section__showcase}>
          {<this.composeProjects />}
        </section>
      </main>
    );
  }
}

export default connect(mapStateToProps)(Home);
