import winston from "winston";

const logger = winston.createLogger({
  level: "debug",
  transports: [
    new winston.transports.Console({
      format: winston.format.combine(
        winston.format.colorize({
          all: true,
        }),
        winston.format.prettyPrint(),
        winston.format.splat(),
        winston.format.simple()
      ),
    }),
  ],
  silent: process.env.NODE_ENV === "production" ? true : false,
});

export default logger;
