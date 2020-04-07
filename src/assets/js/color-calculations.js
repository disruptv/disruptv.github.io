/* eslint-disable no-invalid-this */
/* global Color */
/* eslint no-unused-vars: off */
/**
 * Color Calculations.
 *
 * @since Disruptv 4.5.0
 *
 * @param {string} backgroundColor - The background color.
 * @param {number} accentHue - The hue for our accent color.
 *
 * @return {Object} - this
 */
function _disruptvColor(backgroundColor, accentHue) {
  // Set the object properties.
  this.backgroundColor = backgroundColor;
  this.accentHue = accentHue;
  this.bgColorObj = new Color(backgroundColor);
  this.textColorObj = this.bgColorObj.getMaxContrastColor();
  this.textColor = this.textColorObj.toCSS();
  this.isDark = 0.5 > this.bgColorObj.toLuminosity();
  this.isLight = !this.isDark;

  // Return the object.
  return this;
}

/**
 * Builds an array of Color objects based on the accent hue.
 * For improved performance we only build half the array
 * depending on dark/light background-color.
 *
 * @since Disruptv 4.5.0
 *
 * @return {Object} - this
 */
_disruptvColor.prototype.setAccentColorsArray = function() {
  const self = this;
  const minSaturation = 65;
  const maxSaturation = 100;
  const minLightness = 30;
  const maxLightness = 80;
  const stepSaturation = 2;
  const stepLightness = 2;
  const pushColor = function() {
    const colorObj = new Color({
      h: self.accentHue,
      s: s,
      l: l,
    });

    /**
     * Get a score for this color in contrast to its background color and surrounding text.
     *
     * @since Disruptv 4.5.0
     *
     * @param {number} contrastBackground - WCAG contrast with the background color.
     * @param {number} contrastSurroundingText - WCAG contrast with surrounding text.
     * @return {number} - 0 is best, higher numbers have bigger difference with the desired scores.
     */
    const getScore = function(contrastBackground, contrastSurroundingText) {
      const diffBackground = (7 >= contrastBackground) ? 0 : 7 - contrastBackground;
      const diffSurroundingText = (3 >= contrastSurroundingText) ? 0 : 3 - contrastSurroundingText;

      return diffBackground + diffSurroundingText;
    };

    const item = {
      color: colorObj,
      contrastBackground: colorObj.getDistanceLuminosityFrom(self.bgColorObj),
      contrastText: colorObj.getDistanceLuminosityFrom(self.textColorObj),
    };

    // Check a minimum of 4.5:1 contrast with the background and 3:1 with surrounding text.
    if (4.5 > item.contrastBackground || 3 > item.contrastText) {
      return;
    }

    // Get a score for this color by multiplying the 2 contrasts.
    // We'll use that to sort the array.
    item.score = getScore(item.contrastBackground, item.contrastText);

    self.accentColorsArray.push(item);
  };
  let s; let l;

  this.accentColorsArray = [];

  // We're using `for` loops here because they perform marginally better than other loops.
  for (s = minSaturation; s <= maxSaturation; s += stepSaturation) {
    for (l = minLightness; l <= maxLightness; l += stepLightness) {
      pushColor(s, l);
    }
  }

  // Check if we have colors that are AAA compliant.
  const aaa = this.accentColorsArray.filter(function(color) {
    return 7 <= color.contrastBackground;
  });

  // If we have AAA-compliant colors, always prefer them.
  if (aaa.length) {
    this.accentColorsArray = aaa;
  }

  // Sort colors by contrast.
  this.accentColorsArray.sort(function(a, b) {
    return a.score - b.score;
  });
  return this;
};

/**
 * Get accessible text-color.
 *
 * @since Disruptv 4.5.0
 *
 * @return {Color} - Returns a Color object.
 */
_disruptvColor.prototype.getTextColor = function() {
  return this.textColor;
};

/**
 * Get accessible color for the defined accent-hue and background-color.
 *
 * @since Disruptv 4.5.0
 *
 * @return {Color} - Returns a Color object.
 */
_disruptvColor.prototype.getAccentColor = function() {
  // If we have colors returns the 1st one - it has the highest score.
  if (this.accentColorsArray[0]) {
    return this.accentColorsArray[0].color;
  }

  // Fallback.
  const fallback = new Color('hsl(' + this.accentHue + ',75%,50%)');
  return fallback.getReadableContrastingColor(this.bgColorObj, 4.5);
};

/**
 * Return a new instance of the _disruptvColor object.
 *
 * @since Disruptv 4.5.0
 *
 * @param {string} backgroundColor - The background color.
 * @param {number} accentHue - The hue for our accent color.
 * @return {Object} - this
 */
function disruptvColor(backgroundColor, accentHue) {// jshint ignore:line
  const color = new _disruptvColor(backgroundColor, accentHue);
  color.setAccentColorsArray();
  return color;
}
