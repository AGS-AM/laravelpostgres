// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************
//
//
// -- This is a parent command --
// Cypress.Commands.add("login", (email, password) => { ... })
//
//
// -- This is a child command --
// Cypress.Commands.add("drag", { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add("dismiss", { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This will overwrite an existing command --
// Cypress.Commands.overwrite("visit", (originalFn, url, options) => { ... })

Cypress.Commands.add("login", (username = null, password = null) => {
    username = username || Cypress.env('username')
    password = password || Cypress.env('password')
    let _token
    cy.visit('/login')
        .getCookie('XSRF-TOKEN')
        .then((cookie) => {
            cy.request({
                method: 'POST',
                url: '/login',
                form: true,
                body: {
                    username,
                    password,
                },
                headers: {
                    // Base64 encoded string was URI encoded in headers. Decode it.
                    'X-XSRF-TOKEN': decodeURIComponent(cookie.value)
                }
            });
        });
})