import * as Str from 'core/str';

const SELECTORS = {
    TIME_ELEMENT: 'input[data-time-element]',
    TIME_TOTAL: '#fitem_id_totaltime div.form-control-static',
};

/**
 * Called by Moodle on module load.
 */
export const init = () => {
    document.querySelectorAll(SELECTORS.TIME_ELEMENT)
        .forEach(element => element.addEventListener('input', handleTimeElementInput));

    updateTotalTime();
};

/**
 * Handles the input event for time elements.
 */
const handleTimeElementInput = () => {
    updateTotalTime();
};

/**
 * Updates the total time content based on the time elements.
 */
const updateTotalTime = () => {
    const timeElements = document.querySelectorAll(SELECTORS.TIME_ELEMENT);
    const totalTimeElement = document.querySelector(SELECTORS.TIME_TOTAL);

    const totalTime = calculateTotalTime(timeElements);

    Str.get_string('supportform:totaltimevalue', 'local_support', totalTime.toString())
        .then(string => (totalTimeElement.textContent = string));
};

/**
 * Calculates the total time based on the time elements.
 *
 * @param {NodeListOf<Element>} timeElements Time elements.
 * @returns {number} Total time in minutes.
 */
const calculateTotalTime = (timeElements) => {
    let totalTime = 0;
    timeElements.forEach(element => {
        const value = parseInt(element.value);
        if (isNaN(value)) {
            return;
        }

        const minutes = parseInt(element.dataset.minutes);
        const time = minutes * value;

        totalTime += isNaN(time) ? 0 : time;
    });

    return totalTime;
};