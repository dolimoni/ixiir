var dolimoni=angular.module('dolimoni', []);

dolimoni.constant('BASE_URL', PHP_BASE_URL);


dolimoni.filter('oneOrZero', function() {
	return function(input) {
		return input === true || input === "1" ? 'oui' : 'non' ;
	};
});


dolimoni.filter('yesOrNo', function() {
		return function(input) {
			return input === true || input === 'true' ? 'oui' : 'non' ;
		};
});

dolimoni.filter('NoOrYes', function() {
		return function(input) {
			return input === true || input === 'true' ? 'non' : 'oui' ;
		};
});


dolimoni.filter('ifEmpty', function() {
	return function(input, defaultValue) {
		if (angular.isUndefined(input) || input === null || input === '') {
			return defaultValue;
		}

		return input;
	}
});
