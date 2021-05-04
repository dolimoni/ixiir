var besys=angular.module('besys', []);
besys.constant('BASE_URL', PHP_BASE_URL);


besys.filter('oneOrZero', function() {
	return function(input) {
		return input === true || input === "1" ? 'oui' : 'non' ;
	};
});


besys.filter('yesOrNo', function() {
		return function(input) {
			return input === true || input === 'true' ? 'oui' : 'non' ;
		};
});

besys.filter('NoOrYes', function() {
		return function(input) {
			return input === true || input === 'true' ? 'non' : 'oui' ;
		};
});


besys.filter('ifEmpty', function() {
	return function(input, defaultValue) {
		if (angular.isUndefined(input) || input === null || input === '') {
			return defaultValue;
		}

		return input;
	}
});
