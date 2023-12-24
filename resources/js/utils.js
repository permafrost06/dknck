import { gsap } from 'gsap';
import { CSSPlugin } from 'gsap/CSSPlugin';
gsap.registerPlugin(CSSPlugin);


/**
 * @param {string} selector 
 * @param {HTMLElement} parent 
 * @returns {HTMLElement | null}
 */
export const find = (selector, parent) => (parent || document).querySelector(selector);

/**
* @param {string} selector 
* @param {HTMLElement} parent 
* @returns {HTMLElement[]}
*/
export const findAll = (selector, parent) => (parent || document).querySelectorAll(selector);


/**
 * Adds given classes to the elements
 * @param { HTMLElement | HTMLElement[]} element 
 * @param {string | string[]} classes 
 */
export const addClasses = (element, classes) => {
    if(element.tagName) {
        element = [element];
    }
    if (typeof classes === 'string') {
        classes = classes.split(' ');
    }
    element.forEach((el) => {
        classes.forEach((className) => el.classList.add(className));
    })
}


/**
 * Removes given classes from the elements
 * @param { HTMLElement | HTMLElement[]} element 
 * @param {string | string[]} classes 
 */
export const rmClasses = (element, classes) => {
    if(element.tagName) {
        element = [element];
    }
    if (typeof classes === 'string') {
        classes = classes.split(' ');
    }
    element.forEach((el) => {
        classes.forEach((className) => el.classList.remove(className));
    })
}


/**
 * @returns {gsap.core.Timeline}
 */
export const gsapTL = ()=> gsap.timeline();

/**
 * @param {string} text 
 * @returns string
 */
export const htmlSpecialChars = (text) => {
    const map = {
        '&amp;': '&',
        '&#038;': "&",
        '&lt;': '<',
        '&gt;': '>',
        '&quot;': '"',
        '&#039;': "'",
        '&#8217;': "’",
        '&#8216;': "‘",
        '&#8211;': "–",
        '&#8212;': "—",
        '&#8230;': "…",
        '&#8221;': '”'
    };

    return text.replace(/\&[\w\d\#]{2,5}\;/g, (m) => map[m]);
};