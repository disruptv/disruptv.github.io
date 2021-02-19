import React from "react";
import { connect } from "react-redux";
import { withRouter } from "react-router-dom";
import stripHTML from "../../../utils/stripHTML";
import styles from "./index.module.scss";

const mapStateToProps = (state: any, ownProps: any) => {
  const { projects } = state;

  return {
    projects,
  };
};

class Project extends React.Component<any, any> {
  constructor(props: any) {
    super(props);

    this.state = {
      id: 0,
      client: "",
      title: "",
      date: "",
      excerpt: "",
      content: "",
      skills: [""],
      platforms: [""],
    };
  }

  componentDidMount() {
    this.selectProjectfromProjects();
  }

  componentDidUpdate(prevProps: any) {
    if (prevProps.projects !== this.props.projects) {
      this.selectProjectfromProjects();
    }
  }

  selectProjectfromProjects = () => {
    const Project = this.props.projects
      .filter((project: any) => project.slug === this.props.match.params.id)
      .pop();

    if (Project) {
      this.setState({
        id: Project.id,
        client: "",
        title: stripHTML(Project.title.rendered),
        date: new Date(Project.date).getFullYear(),
        excerpt: stripHTML(Project.excerpt.rendered),
        content: Project.content.rendered,
        skills: [],
        platforms: [],
      });
    }

    return false;
  };

  ComposeLists = (props: any) => {
    return props.items.map((item: any, i: number) => {
      return <li key={i}>{item}</li>;
    });
  };

  render() {
    return (
      <article className={styles.container}>
        <header className={styles.slate}>
          <h1 className={styles.client}>{this.state.client}</h1>
          <h2 className={styles.title}>{this.state.title}</h2>
          <p className={styles.excerpt}>{this.state.excerpt}</p>
          <aside className={styles.details}>
            <ul className={styles.skills}>
              <h3>Skills</h3>
              <this.ComposeLists items={this.state.skills} />
            </ul>
            <ul className={styles.platforms}>
              <h3>Platforms</h3>
              <this.ComposeLists items={this.state.platforms} />
            </ul>
            <time className={styles.date} dateTime={this.state.date}>
              <h3>Date</h3>
              {this.state.date}
            </time>
          </aside>
        </header>
        <section
          className={styles.content}
          dangerouslySetInnerHTML={{ __html: this.state.content }}
        ></section>
        <footer></footer>
      </article>
    );
  }
}

export default withRouter(connect(mapStateToProps)(Project));
