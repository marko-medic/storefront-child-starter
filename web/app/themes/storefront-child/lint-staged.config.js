module.exports = {
  linters: {
    'sfc-assets/**/*.+(js|ts|md|css|sass|less|graphql|yml|yaml|scss|json|vue)': [
      'eslint --fix',
      'prettier --write',
      'git add',
    ],
  },
};
