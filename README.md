# ZenFSE - a blank developer theme for FSE WordPress

Hi devs. This is a blank developer theme per Wordpress using FSE.

ZenFSE it's intended to create a solid, high customizable starting point for building a theme with his own custom
blocks. No external libraries and no frameworks in production: this theme is for mad folks like me who want to have
maximun control over final CSS and JS.

This is the core, minimal version of ZenFSE and it's the best starting point if you want to develope from zero. I also
built an enhanced version (that's the one I use when I start a new project) with some fancy animation and modified core
blocks. You can check it out here: [Fancy ZenFSE](https://pages.github.com/).

## :rocket: Getting Started

To use ZenFSE, clone this repo and just `npm i` and `npm run build` as usual. Use `npm run dev` for developing. Nothing
new.

## :trolleybus: Compiling

I used Webpack (built-in @wordpress/scripts) and Parcel (beacuse it's quick and simpler than webpack). The CSS is
processed by SASS and autoprefixed.

## :school: Project structure

Ok, the folder stucture needs explaination. Here you will see where to put all your code to work in frontend or
dashboard and the folder structure for building your custom blocks or filter the core blocks.

- blocks: where to put your magic. Develope here your custom blocks and register them in [funcions.php](funcions.php)
  under the `/* Custom blocks */` section. They will be compiled in `build-custom-blocks` folder. I left two custom
  blocks (the ones I always use) but you can delete `footer` if you don't need it. Custom block `navigation` is used in
  header template part [header.html](parts/header.html). If you wanto to remome it, please update
  [header.html](parts/header.html) conequently.

  - build-core-blocks: a folder with compiled core blocks filter.
  - build-core-blocks: a folder with compiled core blocks styles.
  - build-custom-blocks: a folder with compiled custom blocks.
  - core-blocks: if you want to add features of a core block you can do it here. I left an example of a filter on the
    core/image block that adds some dimension selector as described below. See
    [Block Filters – Block Editor Handbook](https://developer.wordpress.org/block-editor/reference-guides/filters/block-filters/)
    for more reference.
    - image: in this folder we have some styling and scripts (different from frontend and backend) that are compiled in
      build-core-blocks by webpack (see [webpack.config.js](webpack.config.js)) and parcel (see
      [package.json](package.json)) and imported in [funcions.php](funcions.php) under /_ Filter core blocks _/ section.
      I wanted to add in dashboard a way to set the dimensions of all images, whit a tab switch to set different desktop
      and mobile dimensions. You can use this example to build you own filter to core blocks.
  - custom-blocks: in this folder you can put your custom blocks. The main reason to use a FSE theme is tha you can
    build you custom blocks in a hybrid react-php-html way. Basically you think in a react way on dasboard frontend
    (useEffect and stuff) and use Wp FSE way funcions to render them in site frontend. See
    [Block Editor Handbook](https://developer.wordpress.org/block-editor/) for more reference. The compiling process is
    already present in this theme, you only have to create here a folder for your custom block and put the needed files
    inside.
    - footer: a custom block for footer, usefull if you want to build an animated or complex footer. Remove this folder
      and his registration in [funcions.php](funcions.php) if you only need core wordpress blocks for your footer.
    - navigation: a custom block to have a customizable navigation menù. Set it in header section of wordpress editor.
      It's loaded in [header.html](parts/header.html) and lets you display and style a desktop menù and a different
      mobile menù.

- dist: the build folder for dashboard style and global js.
- parts: FSE parts. The custom "navigation" block is called in [header.html](header.html).
- src: fonts, css and js of the theme.
  - assets: put your svg and images hese
    - fonts: here are fonts imported in theme
  - css: scss files compiled by parcel in [dist/site.css](dist/site.css)
    - base: all global scss files. I use mixin to define typography styles. Put you font weight and styles inside. If
      you change media queries change consequentely the ones in [js/globals.js](js/globals.js).
    - components: add here your custom components scss.
    - dashboard-style: style for Wp dashboard. Because pages are rendered in iframe, I needed to have smaller fonts
      because root fontsize is vw and vh realtive (see [css/base/variables.scss](css/base/variables.scss))
    - parts: scss for parts. Header style is built considering custom block "navigation".
    - template: scss for FSE templates. style.scss is the starting point for compilig scss
  - js: js files compiled by parcel in [dist/site.js](dist/site.js)
    - base: some const like media queries to import in blocks.
    - components: add here your custom components js. site.js is the starting point for compilig js
- templates: the FSE templates. I added a Legal template for privacy policy stuff, if you want a plain page.

The other files are the standard theme files. Style.css is the compiled version of [src/style.scss](src/style.scss).

## :partying_face: How to use

Style your theme in [src/css/base](src/css/base) and [theme.json](theme.json). Change font sizes, families, colors, paddings and so on. But the main purpous of this theme is building a compiling system to ease the process of creating you custom blocks. So, just add a new folder in [blocks/custom-blocks](blocks/custom-blocks), put inside your files, register them in [functions.php](functions.php) from [blocks/build-custom-blocks](blocks/build-custom-blocks) and go. They will be automatically compiled. 

Happy coding.

## :sunglasses: License

This project is licensed under the GNU License - see the [license.txt](license.txt) file for details.
