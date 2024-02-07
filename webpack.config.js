const path = require("path");
const defaultConfig = require("@wordpress/scripts/config/webpack.config");

const imageDimensionConfig = {
  ...defaultConfig,
  entry: {
    "image-dimension": "./blocks/core-blocks/image/image-dimension.js",
    "image-dimension-frontend": "./blocks/core-blocks/image/image-dimension-frontend.js",
  },
  output: {
    path: path.resolve(__dirname, "blocks/build-core"),
    filename: "[name].js",
  },
};


module.exports = [defaultConfig, imageDimensionConfig];
