context('Actions', () => {
    before(() => {
        cy.login().visit('/user_infos')
    })
    beforeEach(() => {
        Cypress.Cookies.preserveOnce('laravel_session', 'XSRF-TOKEN')

        // cy.get('#username')
        //     .type('jacobson.pablo')
        //     .should('have.value', 'jacobson.pablo')
        // cy.get('#password')
        //     .type('12345678ABC')
        //     .should('have.value', '12345678ABC')
        // cy.get('#loginbtn').click()
    });

    // it('enters username', () => {
    //     cy.get('#username')
    //         .type('jacobson.pablo')
    //         .should('have.value', 'jacobson.pablo')
    // })
    // it('enters password', () => {
    //     cy.get('#password')
    //         .type('12345678ABC')
    //         .should('have.value', '12345678ABC')
    // })
    // it('DOES BOTH', () => {
    //     cy.get('#username')
    //         .type('jacobson.pablo')
    //         .should('have.value', 'jacobson.pablo')
    //     cy.get('#password')
    //         .type('12345678ABC')
    //         .should('have.value', '12345678ABC')
    //     cy.get('#loginbtn').click()
    // })

    it('goes in and leaves and logs in properlly', () => {
        cy.wait(2000)
        cy.get('#yeet').click()
        cy.get('#username')
            .type('jacobson.pablo')
            .should('have.value', 'jacobson.pablo')
        cy.get('#password')
            .type('12345678ABC')
            .should('have.value', '12345678ABC')
        cy.get('#loginbtn').click()
    });
    it('cy.window() - get the global window object', () => {
        // https://on.cypress.io/window
        cy.window().should('have.property', 'top')
    });
    it('cy.document() - get the document object', () => {
        // https://on.cypress.io/document
        cy.document().should('have.property', 'charset').and('eq', 'UTF-8')
    });

    it('cy.title() - get the title', () => {
        // https://on.cypress.io/title
        cy.title().should('include', 'User Informations')
    });
    it('changes the search terms', () => {
        cy.get('#searchfrom').select('Name').should('have.value', '1')
        cy.get('#myInputTextField').type('Joan')
        cy.get('#users-table tr').should('contain', 'Joan')

        cy.get('#searchfrom').select('Surname').should('have.value', '2')
        cy.get('#myInputTextField').type('Balistreri')
        cy.get('#users-table tr').should('contain', 'Balistreri')

        cy.get('#searchfrom').select('Username').should('have.value', '3')
        cy.get('#myInputTextField').type('hessel.elody')
        cy.get('#users-table tr').should('contain', 'hessel.elody')

        cy.get('#searchfrom').select('Phone').should('have.value', '4')
        cy.get('#myInputTextField').type('4235')
        cy.get('#users-table tr').should('contain', '4235')

        cy.get('#searchfrom').select('Email').should('have.value', '5')
        cy.get('#myInputTextField').type('huels')
        cy.get('#users-table tr').should('contain', 'huels.rodrick@example.net')
    });
    it('Adds someone & deletes it', () => {
        cy.wait(2000)
        cy.get('#addbtn').click()

        cy.get('#eName').type('cytest')
        cy.get('#eSurName').type('cytest')
        cy.get('#eUser').type('cytest')
        cy.get('#ePhone').type('12345678')
        cy.get('#eEmail').type('cytest@testcy.cy')
        cy.get('#ePass').type('cytest123')
        cy.get('#ePassC').type('cytest123')
        cy.get('#eSave').click()
        cy.get('#myInputTextField').type('{selectall}{del}cytest')

        cy.wait(2000)
        cy.get('#users-table tr').get('#editbtn').click()

        cy.get('#eDel').click()
        cy.get('#eDel2').click()
        cy.wait(2000)
    });
    it('Adds someone & edits it', () => {
        cy.wait(2000)
        cy.get('#addbtn').click()

        cy.get('#eName').type('cytest')
        cy.get('#eSurName').type('cytest')
        cy.get('#eUser').type('cytest')
        cy.get('#ePhone').type('12345678')
        cy.get('#eEmail').type('cytest@testcy.cy')
        cy.get('#ePass').type('cytest123')
        cy.get('#ePassC').type('cytest123')
        cy.get('#eSave').click()
        cy.get('#myInputTextField').type('{selectall}{del}cytest')

        cy.wait(2000)
        cy.get('#users-table tr').get('#editbtn').click()
        cy.wait(2000)
        cy.get('#eName').type('edit')
        cy.get('#eSurName').type('edit')
        cy.get('#eUser').type('edit')
        cy.get('#ePhone').type('{selectall}{backspace}555555555')
        cy.get('#eEmail').type('{selectall}{del}newcymail@mailedcy.cy')
        cy.get('#eSave').click()
        cy.wait(2000)
        cy.get('#searchfrom').select('Name').should('have.value', '1')
        cy.get('#myInputTextField').type('{selectall}{del}cytest')
        cy.get('#users-table tr').should('contain', 'cytestedit')

    });

    it('finds itself and deletes it', () => {
        cy.get('#searchfrom').select('Name').should('have.value', '1')
        cy.get('#myInputTextField').type('{selectall}{del}cytest')
        cy.wait(2000)
        cy.get('#users-table tr').get('#editbtn').click()
        cy.get('#eDel').click()
        cy.get('#eDel2').click()
        cy.wait(2000)
    });

    it('leaves to register and leave to remove regiestered acc', () => {
        cy.wait(2000)
        cy.get('#yeet').click()
        cy.visit('http://127.0.0.1:8000/register')
        cy.get('#name').type('cytest')
        cy.get('#surname').type('cytest')
        cy.get('#username').type('cytest')
        cy.get('#phone').type('12345678')
        cy.get('#email').type('cytest@testcy.cy')
        cy.get('#password').type('cytest123')
        cy.get('#password-confirm').type('cytest123')
        cy.get('#register').click()

        cy.wait(2000)
        cy.get('#yeet').click()

        cy.visit('http://127.0.0.1:8000/')
        cy.get('#username')
            .type('jacobson.pablo')
            .should('have.value', 'jacobson.pablo')
        cy.get('#password')
            .type('12345678ABC')
            .should('have.value', '12345678ABC')
        cy.get('#loginbtn').click()

        cy.get('#searchfrom').select('Name').should('have.value', '1')
        cy.get('#myInputTextField').type('{selectall}{del}cytest')
        cy.wait(2000)
        cy.get('#users-table tr').get('#editbtn').click()
        cy.get('#eDel').click()
        cy.get('#eDel2').click()
        cy.wait(2000)

        cy.get('#yeet').click()
    });
});