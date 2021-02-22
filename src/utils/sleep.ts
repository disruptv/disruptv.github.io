const sleep = (seconds: number | string): Promise<void> => {
  return new Promise((resolve) =>
    setTimeout(resolve, parseInt(seconds as string) * 1000)
  );
};

export default sleep;
