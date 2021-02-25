import axios from "axios";
import React, { Dispatch } from "react";
import { connect } from "react-redux";
import { getProjectPosts, getTagsByID } from "../../../store/actions";
import htmlDecode from "../../../utils/htmlDecode";
import styles from "./index.module.scss";

const mapStateToProps = (state: any, ownProps: any) => {
  const { projects, settings } = state;

  return { jobs: projects, settings };
};

const mapDispatchToProps = (dispatch: Dispatch<any>, ownProps: any) => {
  return {
    getJobs: () => dispatch(getProjectPosts()),
    getSkills: () => getTagsByID(),
  };
};

class Resume extends React.Component<any, any> {
  constructor(props: any) {
    super(props);

    this.state = {
      fullName: "Aaron Salley",
      bio: "This is a bio.",
      contacts: [],
      jobs: [],
      educations: [
        {
          school: "School",
          location: "City, State",
          degree: "Degree",
          startDate: "MM/DD/YYYY",
          endDate: "MM/DD/YYYY",
          summary: "",
        },
      ],
      skills: [],
      languages: ["English", "Spanish", "Italian"],
    };
  }

  componentDidMount = async () => {
    this.props.getJobs();
    let skills = await this.props.getSkills();
    skills = skills.map((skill: any) => {
      return skill.name;
    });

    this.setState({
      skills: skills,
    });
  };

  componentDidUpdate = (prevProps: any, state: any) => {
    if (prevProps.settings.projectCatId !== this.props.settings.projectCatId) {
      this.props.getJobs();
    }
    if (prevProps.projects !== this.props.projects) {
      this.composeJobs();
    }
  };

  composeContacts = () => {
    const contacts = this.state.contacts.map((contact: any, i: string) => {
      return <article key={i}>{contact.title}</article>;
    });
    return <ul className={styles.contacts}>{contacts}</ul>;
  };

  composeJobs = () => {
    const jobs = this.props.jobs.map((job: any, i: number) => {
      let articleStyles: string | string[] = ["job"];
      job.status === "current" || i === 0
        ? articleStyles.push("active")
        : articleStyles.push();
      articleStyles = articleStyles
        .map((style: string) => {
          return styles[style];
        })
        .join(" ");

      return (
        <article className={articleStyles} key={i}>
          <div>
            <span className={styles.company}>{job.company},</span>
            <span className={styles.location}>{job.location}</span>
            <span className={styles.roleTitle}>{job.roleTitle}</span>
          </div>
          <div className={styles.dates}>
            {job.endDate} - {job.startDate}
          </div>
          <div>{htmlDecode(job.excerpt.rendered)}</div>
        </article>
      );
    });
    return (
      <main className={styles.jobs}>
        <h2>Professional Experience</h2>
        {jobs}
      </main>
    );
  };

  composeEducations = () => {
    const educations = this.state.educations.map(
      (education: any, i: string) => {
        return (
          <article className={styles.education} key={i}>
            <div>
              <span className={styles.school}>{education.school},</span>
              <span className={styles.location}>{education.location}</span>
              <span className={styles.degree}>{education.degree}</span>
            </div>
            <div>
              {education.endDate} - {education.startDate}
            </div>
            <div>{education.summary}</div>
          </article>
        );
      }
    );
    return (
      <section className={styles.education}>
        <h2>Education</h2>
        {educations}
      </section>
    );
  };

  ComposeLists = (props: any) => {
    if (props.items) {
      const items = props.items.map((item: any, i: number) => {
        return <li key={i}>{htmlDecode(item)}</li>;
      });

      return <ul>{items}</ul>;
    }
    return null;
  };

  render = () => {
    return (
      <article className={styles.document}>
        <header>
          <h1>{this.state.fullName}</h1>
          <this.composeContacts />
          <section>
            <h2>Executive Summary</h2>
            <p>{this.state.bio}</p>
          </section>
        </header>
        <div>
          <this.composeJobs />
          <aside className={styles.about}>
            <section>
              <h2>Big 5 (OCEAN)</h2>
            </section>
            <section className={styles.skills}>
              <h2>Skills</h2>
              <this.ComposeLists items={this.state.skills} />
            </section>
            <section className={styles.languages}>
              <h2>Languages</h2>
              <this.ComposeLists items={this.state.languages} />
            </section>
            <this.composeEducations />
          </aside>
        </div>
      </article>
    );
  };
}

export default connect(mapStateToProps, mapDispatchToProps)(Resume);
