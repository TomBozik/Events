module.exports = {
    purge: {
      content: [
        "app/**/*.php",
        "resources/**/*.html",
        "resources/**/*.js",
        "resources/**/*.jsx",
        "resources/**/*.ts",
        "resources/**/*.tsx",
        "resources/**/*.php",
        "resources/**/*.vue",
        "resources/**/*.twig",
      ],
      options: {
          // defaultExtractor: (content) => content.match(/[\w-/.:]+(?<!:)/g) || [],
          whitelistPatterns: [/-active$/, /-enter$/, /-leave-to$/, /show$/],
      }
    },
    variants: {
      borderColor: ['responsive', 'hover', 'focus', 'focus-within'],
    },
    plugins: []
  }