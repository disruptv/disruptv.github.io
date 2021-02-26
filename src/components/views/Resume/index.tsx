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
      bio: `Having careers in the arts and tech, my philosophy leverages connections between diverse experiences.
      I draw from human-centered yet pragmatic technical skills to bring conscientiousness, creativity, and strategic thinking to all that I do.
      Over the last decade, I've worked with startups and established companies alike — taking ideas from mind to market.`,
      contacts: [
        {
          title: "New York, NY",
        },
        {
          title: "646-535-0114",
          url: "tel:+16465350114",
        },
        {
          title: "aaron@disruptv.llc",
          url: "mailto:aaron@disruptv.llc",
        },
        {
          title: "linkedin.com/in/aaronsalley",
          url: "https://linkedin.com/in/aaronsalley",
        },
      ],
      educations: [
        {
          school: "NYU Stern School of Business",
          location: "New York, NY",
          degree: "MBA",
          summary:
            "Entrepreneurship & Innovation, Mgmt. of Technology & Operations, General Management; Class President",
        },
        {
          school: "Stanford University",
          location: "Stanford, CA",
          degree: "Certificate",
          summary: "Machine Learning",
        },
        {
          school: "UNC Chapel Hill",
          location: "Chapel Hill, NC",
          degree: "BA",
        },
      ],
      skills: [],
      languages: ["English", "Spanish", "Italian"],
      references: [],
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
      return (
        <article key={i}>
          {contact.url ? (
            <a href={contact.url}>{contact.title}</a>
          ) : (
            contact.title
          )}
        </article>
      );
    });
    return <ul className={styles.contacts}>{contacts}</ul>;
  };

  sortJobs = () => {
    this.props.jobs.sort((a: any, b: any) => {
      const startA = new Date(a.meta.disruptv_start_date);
      const startB = new Date(b.meta.disruptv_start_date);

      if (startA > startB) {
        return -1;
      } else if (startB > startA) {
        return 1;
      }

      return 0;
    });
  };

  formatDate = (date: Date) => {
    return `${new Intl.DateTimeFormat("en-US", { month: "long" }).format(
      date
    )} ${date.getFullYear()}`;
  };

  composeJobs = () => {
    this.sortJobs();

    const jobs = this.props.jobs.map((job: any, i: number) => {
      let {
        disruptv_company: company,
        disruptv_location: location,
        disruptv_job_title: roleTitle,
        disruptv_start_date: startDate,
        disruptv_end_date: endDate,
      } = job.meta;

      startDate = this.formatDate(new Date(startDate));
      endDate = endDate !== "" ? this.formatDate(new Date(endDate)) : "Present";

      let articleStyles: string | string[] = ["job"];
      endDate === "Present"
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
            <span className={styles.company}>{company},</span>
            <span className={styles.location}>{location}</span>
            <i></i>
            <span className={styles.roleTitle}>{roleTitle}</span>
          </div>
          <div className={styles.dates}>
            {startDate} - {endDate}
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
              <p className={styles.school}>{education.school}</p>
              <span className={styles.location}>{education.location}</span>
              <span className={styles.degree}>{education.degree}</span>
              <span> {education.endDate}</span>
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
          <section className={styles.statement}>
            <h2>Executive Summary</h2>
            <p>{this.state.bio}</p>
          </section>
        </header>
        <div>
          <this.composeJobs />
          <aside className={styles.about}>
            <section className={styles.big5}></section>
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
