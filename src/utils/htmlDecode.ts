const htmlDecode = (string: string): string | null => {
  const doc = new DOMParser().parseFromString(string, "text/html");
  return doc.documentElement.textContent;
};
export default htmlDecode;
