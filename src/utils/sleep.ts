const sleep = (seconds: number | string) => {
  return new Promise((resolve) =>
    setTimeout(resolve, parseInt(seconds as string) * 1000)
  );
};

export default sleep;
