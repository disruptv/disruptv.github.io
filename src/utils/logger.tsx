import winston from "winston";

const logger = winston.createLogger({
  level: "debug",
  transports: [
    new winston.transports.Console({
      format: winston.format.combine(
        winston.format.prettyPrint({
          depth: 2,
          colorize: true,
        })
      ),
    }),
  ],
  silent: process.env.NODE_ENV === "production" ? true : false,
});

export default logger;
