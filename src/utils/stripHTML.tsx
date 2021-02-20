const stripHTML = (string: string): string =>
  string.replace(/(<([^>]+)>)/gi, "");
export default stripHTML;
