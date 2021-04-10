module.exports = {
  linters: {
    'sfc-assets/**/*.+(js|ts|md|ts|css|sass|less|graphql|yml|yaml|scss|json|vue)': [
      'eslint --fix',
      'prettier --write',
      'git add',
    ],
  },
};
