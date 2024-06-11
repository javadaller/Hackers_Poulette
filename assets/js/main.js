import { sendForm } from "./request.js"

//init
const honeypot = document.querySelector('#honeypotID')
honeypot.style.display = 'none'

const inputName = document.querySelector('#nameID')
const surname = document.querySelector('#surnameID')
const gender = document.querySelector('#genderID')
const email = document.querySelector('#emailID')
const country = document.querySelector('#countryID')
const subject = document.querySelector('#subjectID')
const message = document.querySelector('#messageID')

const form = [inputName, surname, gender, email, country, subject, message]

form.forEach(element => {
    switch (element) {
        case gender:
            element.value = 'none'
            break

        case subject:
            element.value = 'other'
            break

        default:
            element.value = ''
    }
});

//send form
document.querySelector('#sendButton').addEventListener('click', () => {
    if(honeypot.value != '') {
        console.log('You fool')
    } else {
        sendForm() 
    }
})

//socials
document.querySelector('#github').addEventListener('click', () => {
    open('https://github.com/javadaller','_blank')
})

document.querySelector('#linkedin').addEventListener('click', () => {
    open('https://www.linkedin.com/in/arnaud-van-acker','_blank')
})