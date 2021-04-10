/// <reference types="cypress" />

describe('The Home Page', () => {
  it('successfully loads', () => {
    cy.visit('http://storefront-child-starter/');
    cy.contains('Homepage content');
    cy.contains('Built with Storefront@@').should('not.exist');
  });
});
