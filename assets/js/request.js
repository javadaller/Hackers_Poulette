import { escapeHTML } from "./fnc.js";

export async function sendForm() {
    console.log('ok');
    const inputName = document.querySelector('#nameID');
    const surname = document.querySelector('#surnameID');
    const gender = document.querySelector('#genderID');
    const email = document.querySelector('#emailID');
    const country = document.querySelector('#countryID');
    const subject = document.querySelector('#subjectID');
    const message = document.querySelector('#messageID');

    const form = [inputName, surname, gender, email, country, subject, message];

    form.forEach(element => {
        element.classList.remove('error');
        element.nextElementSibling.innerHTML = '';
    });

    if (inputName.value.length == 0) {
        error(inputName, 'Please enter your name');
        return;
    } else if (surname.value.length == 0) {
        error(surname, 'Please enter your surname');
        return;
    } else if (gender.value == 'none') {
        error(gender, 'Please choose your gender');
        return;
    } else if (email.value.length == 0) {
        error(email, 'Please enter a valid e-mail');
        return;
    } else if (country.value.length == 0) {
        error(country, 'Please enter your country');
        return;
    } else if (message.value.length == 0) {
        error(message, 'Please write a message');
        return;
    }

    const data = {
        name: escapeHTML(inputName.value),
        surname: escapeHTML(surname.value),
        gender: escapeHTML(gender.value),
        email: escapeHTML(email.value),
        country: escapeHTML(country.value),
        subject: escapeHTML(subject.value),
        message: escapeHTML(message.value),
    };

    try {
        const response = await fetch('assets/php/postMessage.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const result = await response.json();

        if (result.status === 'success') {
            console.log('Email sent:', result.message);
        } else {
            console.error('Error:', result.message);
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

function error(input, message) {
    input.classList.add('error');
    input.nextElementSibling.innerHTML = message;
}
