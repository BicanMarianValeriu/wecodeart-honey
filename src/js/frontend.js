/**
 * @package: 	WeCodeArt Customs
 * @author: 	Bican Marian Valeriu 
 * @version:	1.0.0
 */
import './../scss/frontend.scss';

// Common JS
import common from './routes/common';

const { hooks: { addAction } } = wp;

addAction('wecodeart.route', 'wecodeart/skin/common', extendCommon, 10);
function extendCommon(route, func) {
	if (route === 'common' && func === 'init') {
		common['init']();
		common['complete']();
	}
}