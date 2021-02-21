import React, { Dispatch } from "react";
import { connect } from "react-redux";
import { withRouter } from "react-router-dom";
import {
  getCatsByID,
  getProjectPosts,
  getTagsByID,
} from "../../../store/actions";
import htmlDecode from "../../../utils/htmlDecode";
import styles from "./index.module.scss";

const mapStateToProps = (state: any, ownProps: any) => {
  const { projects, settings } = state;

  return {
    projects,
    settings,
  };
};

const mapDispatchToProps = (dispatch: Dispatch<any>) => {
  return {
    getProjects: () => dispatch(getProjectPosts()),
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
    this.props.getProjects();
    this.selectProjectfromProjects();
  }

  componentDidUpdate(prevProps: any) {
    if (prevProps.settings.projectCatId !== this.props.settings.projectCatId) {
      this.props.getProjects();
    }

    if (prevProps.projects !== this.props.projects) {
      this.selectProjectfromProjects();
    }
  }

  selectProjectfromProjects = async () => {
    const Project = this.props.projects
      .filter((project: any) => project.slug === this.props.match.params.id)
      .pop();

    if (Project) {
      const skills = await getTagsByID(Project.tags);
      const platforms = await getCatsByID(
        Project.categories.filter((cat: number) => cat !== 3)
      );

      this.setState({
        id: Project.id,
        client: "",
        title: htmlDecode(Project.title.rendered),
        date: new Date(Project.date).getFullYear(),
        excerpt: htmlDecode(Project.excerpt.rendered),
        content: String(Project.content.rendered),
        skills: this.selectNames(skills),
        platforms: this.selectNames(platforms),
        image: Project.featured_image_url[0],
      });
    }

    return false;
  };

  selectNames = (terms: void | any[]) => {
    const termNames: string[] = [];
    if (terms) {
      terms.map((term: any) => {
        return termNames.push(term.name);
      });
    }
    return termNames;
  };

  ComposeLists = (props: any) => {
    return props.items.map((item: any, i: number) => {
      return <li key={i}>{item}</li>;
    });
  };

  render() {
    return (
      <article className={styles.container}>
        <header
          className={styles.slate}
          style={{ backgroundImage: `url(${this.state.image}` }}
        >
          <h1 className={styles.client}>{this.state.client}</h1>
          <h2 className={styles.title}>{this.state.title}</h2>
          <p className={styles.excerpt}>{this.state.excerpt}</p>
          <aside className={styles.details}>
            <ul className={styles.skills}>
              {this.state.skills.length > 0 ? <h3>Skills</h3> : null}
              <this.ComposeLists items={this.state.skills} />
            </ul>
            <ul className={styles.platforms}>
              {this.state.platforms.length > 0 ? <h3>Platforms</h3> : null}
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

export default withRouter(
  connect(mapStateToProps, mapDispatchToProps)(Project)
);
