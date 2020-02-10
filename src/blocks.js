/**
 * Gutenberg Blocks
 *
 * All blocks related JavaScript files should be imported here.
 * You can create a new block folder in this dir and include code
 * for that block here as well.
 *
 * All blocks should be included here since this is the file that
 * Webpack is compiling as the input file.
 */

const { updateCategory } = wp.blocks;
const { SVG, G, Path, Rect } = wp.components;

(function() {
	updateCategory('recipetron', { icon: (
		<SVG
			xmlns="http://www.w3.org/2000/svg"
			version="1.1"
			width="24"
			height="24"
			viewBox="0 0 24 24"
		>
			<G>
				<Path d="M20,9H4l0,0c0-1.1,0.9-2,2-2h12C19.1,7,20,7.9,20,9L20,9z"/>
				<Path d="M20,12v-2H4v2c-1.1,0-2,0.9-2,2h2v3c0,1.1,0.9,2,2,2h12c1.1,0,2-0.9,2-2v-3h2C22,12.9,21.1,12,20,12z M7.5,16
					C6.7,16,6,15.3,6,14.5S6.7,13,7.5,13S9,13.7,9,14.5C9,15.3,8.3,16,7.5,16z M14,17h-4v-1h4V17z M16.5,16c-0.8,0-1.5-0.7-1.5-1.5
					s0.7-1.5,1.5-1.5c0.8,0,1.5,0.7,1.5,1.5C18,15.3,17.3,16,16.5,16z"/>
				<Rect x="10" y="4" width="4" height="2"/>
			</G>
		</SVG>
	) });
})();

import './blocks/recipe';
