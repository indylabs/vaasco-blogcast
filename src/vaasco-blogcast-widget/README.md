# Vaasco Blogcast Widget

Vaasco Blogcast allows visitors listen to your content while driving, working out and in other handfree environments. It also makes your content accessible to users with visual impairments and motor disabilities.

The widget is powered by Polly, an Amazon AI service that uses advanced deep learning technologies to synthesize speech that sounds like a human voice. This results in high-quality voice output and word pronunciation.

[https://www.vaasco.com/](https://www.vaasco.com/)


## Development

Run the following commands and tasks to load dependencies and build the project:

### Load node dependencies

`npm install`	

Required before running gulp tasks

### Build widget

`gulp build`

Builds the Vaasco Blogcast widget by running the following tasks in sequence;

- `gulp npm-update`
- `gulp bower-update`
- `gulp eslint`
- `gulp polylint`
- `gulp polymer-build`

### Update node dependencies

`gulp npm-update`

### Update bower dependencies

`gulp bower-update`

### Lint JavaScript

`gulp eslint`

### Lint Polymer

`gulp polylint`

### Build Polymer web componenets

`gulp polymer-build`



## Structure

The Vaasco Blogcast widget is composed of a series of nested [Polymer](https://www.polymer-project.org/) web components:


### vaasco-aws/vaasco-aws

Used internally by `<vaasco-aws-cognito>`

Wrapper for custom AWS SDK build including AWS.CognitoIdentity and AWS.Polly. Created at https://sdk.amazonaws.com/builder/js/

Located at: `/src/components/vaasco-aws/vaasco-aws.html`


### vaasco-aws/vaasco-aws-cognito

`<vaasco-aws-cognito cognito-id-url="{{COGNITO ID URL}}"></vaasco-aws-cognito>`

- Requests CognitoIdentityCredentials from AWS
- Fires vaasco-aws-cognito-credentials event with credentials

Located at: `/src/components/vaasco-aws/vaasco-aws-cognito.html`


### vaasco-common/vaasco-controls-toggle

`<vaasco-controls-toggle 
	spinner="[BOOLEAN]" 
	play="[BOOLEAN]" 
	index="[NUMBER]" 
	color="[STRING]">
</vaasco-controls-toggle>`

- Play / Pause UI component

Located at: `/src/components/vaasco-common/vaasco-controls-toggle.html`


### vaasco-common/vaasco-icons

Used internally by other components

SVG icons used throughout the app

Located at: `/src/components/vaasco-common/vaasco-icons.html`


### vaasco-common/vaasco-styles

Used internally by other components

CSS styles used throughout the app

Located at: `/src/components/vaasco-common/vaasco-styles.html`


### vaasco-common/vaasco-synthesis-polly

`<vaasco-synthesis-polly aws="[AWS OBJECT]"
      utterance="[STRING]"
      active="[BOOLEAN]"
      progress="[NUMBER]"
      index="[NUMBER]">
    </vaasco-synthesis-polly>`
    
Provides an interface with [Amazon Polly](https://aws.amazon.com/polly/)

Located at: `/src/components/vaasco-common/vaasco-synthesis-polly.html`


### vaasco-utilities/vaasco-dates

Used internally by other componenets

Wrapper for moment.js

Located at: `/src/components/vaasco-utilities/vaasco-dates.html`


### vaasco-utilities/vaasco-html

`<vaasco-html html="[HTML STRING]"></vaasco-html>`

Injects HTML into a template

Located at: `/src/components/vaasco-utilities/vaasco-html.html`


### vaasco-utilities/vaasco-versions

`<vaasco-versions versions="[VERSIONS OBJECT]"></vaasco-versions>`

Outputs WordPress, plugin and widget information

Located at: `/src/components/vaasco-utilities/vaasco-versions.html`

 
### vaasco-widget/vaasco-widget.html

`<vaasco-widget options="[WORDPRESS SETTINGS OBJECT]"></vaasco-widget>`

Vaasco Blogcast container component

Located at: `/src/components/vaasco-widget/vaasco-widget.html`

### vaasco-widget/vaasco-widget-controls.html

`<vaasco-widget-controls 
	class$="bg-[COLOR STRING]-500"
   play="[BOOLEAN]" 
   index="[BOOLEAN]"
   spinner="[BOOLEAN]">
</vaasco-widget-controls>`

Widget control panel UI component

Located at: `/src/components/vaasco-widget/vaasco-widget-controls.html`


### vaasco-widget/vaasco-widget-details.html

`<vaasco-widget-details post="[WORDPRESS POST OBJECT]"></vaasco-widget-details>`

Post / track excerpt UI component

Located at: `/src/components/vaasco-widget/vaasco-widget-details.html`


### vaasco-widget/vaasco-widget-panel.html

`<vaasco-widget-panel 
  opened="[BOOLEAN]" 
  config="[CONFIG OBJECT]" 
  posts="[WORDPRESS POSTS ARRAY]">
</vaasco-widget-panel>`

Main panel UI component and controller

Located at: `/src/components/vaasco-widget/vaasco-widget-panel.html`


### vaasco-widget/vaasco-widget-playlists.html

`<vaasco-widget-playlists 
	class$="bg-[COLOR STRING]-300" 
	playlists="[PLAYLISTS ARRAY]" 
	selected="[NUMBER]">
</vaasco-widget-playlists>`

Playlists UI component

Located at: `src/components/vaasco-widget/vaasco-widget-playlists.html`


### vaasco-widget/vaasco-widget-post.html

`<vaasco-widget-post 
	config="[CONFIG OBJECT]"
	post="[WORDPRESS POST OBJECT]" 
	index="[NUMBER]" 
	tabindex$="[NUMBER]">
</vaasco-widget-post>`

Post / track UI component

Located at: `/src/components/vaasco-widget/vaasco-widget-post.html


### vaasco-widget/vaasco-widget-posts.html

`<vaasco-widget-posts
	posts="[WORDPRESS POSTS ARRAY]"
	config="[CONFIG OBJECT]"
	spinner="[BOOLEAN]">
</vaasco-widget-posts>`

Posts / tracks list UI component

Located at: `/src/components/vaasco-widget/vaasco-widget-posts.html


### vaasco-widget/vaasco-widget-progress.html

`<vaasco-widget-progress 
	color="[COLOR STRING]" 
	progress="[NUMBER]">
</vaasco-widget-progress>`

Progress bar UI component

Located at: `/src/components/vaasco-widget/vaasco-widget-progress.html


### vaasco-widget/vaasco-widget-start.html

`<vaasco-widget-start 
	color="[COLOR STRING]" 
	active=[BOOLEAN] 
	on-tap="[TOGGLE PANEL FUNCTION]">
</vaasco-widget-start>`

Start button UI component

Located at: `/src/components/vaasco-widget/vaasco-widget-start.html`


### vaasco-widget/vaasco-widget-toolbar.html

`<vaasco-widget-toolbar 
	heading="[STRING]" 
	color="[COLOR STRING]">
</vaasco-widget-toolbar>`

Widget toolbar UI component

Located at: `/src/components/vaasco-widget/vaasco-widget-toolbar.html'








