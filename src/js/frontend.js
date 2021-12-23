/**
 * @package: 	WeCodeArt Customs
 * @author: 	Bican Marian Valeriu 
 * @version:	1.0.0
 */
import './../scss/frontend.scss';

import loadjs from 'loadjs';
import helperGetParents from './helpers/getParents';

// Common JS
import common from './routes/common';
import archiveChangelog from './routes/archive-changelog';
import singleChangelog from './routes/single-changelog';
import singleDocument from './routes/single-document';

// Attach Some Required Plugins
wecodeart.fn.loadJs = loadjs;
wecodeart.fn.getParents = helperGetParents;

const { hooks: { addAction } } = wp;

addAction('wecodeart.route', 'wecodeart/skin/common', extendCommon, 10);
function extendCommon(route, func) {
	if (route === 'common') {
		common[func]();
	}
}

// Attach Specific Route JS
wecodeart = {
	...wecodeart,
	...{
		lazyJs: {
			...wecodeart.lazyJs,
			...{
				'select2': [
					'//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
				],
			}
		},
		routes: {
			/** 
			 * This prop includes the global JS fired on every page
			 */
			...wecodeart.routes,
			postTypeArchiveChangelog: {
				complete: archiveChangelog,
			},
			singleChangelog: {
				init: singleChangelog,
				extends: ['post-type-archive-changelog'],
			},
			singleDocument: {
				init: singleDocument,
				extends: ['home']
			},
		}
	}
};