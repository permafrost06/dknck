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
