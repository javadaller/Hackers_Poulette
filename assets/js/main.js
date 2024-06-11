import { sendForm } from "./request.js"

//init
const inputName = document.querySelector('#nameID');
const surname = document.querySelector('#surnameID');
const gender = document.querySelector('#genderID');
const email = document.querySelector('#emailID');
const country = document.querySelector('#countryID');
const subject = document.querySelector('#subjectID');
const message = document.querySelector('#messageID');

const form = [inputName, surname, gender, email, country, subject, message];

form.forEach(element => {
    element.value = ''
});

//send form
document.querySelector('#sendButton').addEventListener('click', () => {
    sendForm()
})