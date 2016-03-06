var app = angular.module('app', ['ngRoute']);

var UserModel = function() {
    
};

var DefaultController = function($scope) {
    
};

var UserController = function ($scope, $http) {
    var list = [
        {name: 'Radu Ionita',     status: true},
        {name: 'Raluca Butnariu', status: true},
        {name: 'Catalin Stoica',  status: true},
        {name: 'Bogdan Marcu',    status: false}
    ];
    
    $http.get(Routing.generate('PromoAngularBundleUserFind')).success(function(response) {
        for (var i = 0, l = response.data.length; i < l; ++i) {
            var user = response.data[i];
            list.push({ name: user.name, status: user.status });
        }
    });

    var self = this;

    self.name   = '';
    self.status = false;

    self.add = function() {
        if(self.text !== '') {
            list.push({ name: self.name, status: false});
            self.name = '';
        }
    };

    self.findOne = function(criteria) {

    };

    self.findAll = function(criteria) {
        criteria = criteria || null;
        var result = [];
        angular.forEach(list, function (item) {
            if (typeof criteria !== 'object' || criteria === null) {
                result = list;
            } else {
                for (var field in criteria) {
                    if (criteria.hasOwnProperty(field)) {
                        if(typeof item[field] !== 'undefined' && item[field] == criteria[field]) {
                            result.push(item);
                        }
                    }
                }
            }
        });
        return result;
    };

    self.count = function(criteria) {
        criteria = criteria || null;
        var count = 0;
        angular.forEach(list, function (item) {
            if (typeof criteria !== 'object' || criteria === null) {
                ++count;
            } else {
                for (var field in criteria) {
                    if (criteria.hasOwnProperty(field)) {
                        if(typeof item[field] !== 'undefined' && item[field] == criteria[field]) {
                            ++count;
                        }
                    }
                }
            }
        });
        return count;
    };
};

app.config(function($interpolateProvider) {
    //$interpolateProvider.startSymbol('[[').endSymbol(']]');
});

app.config(function($routeProvider) {
    $routeProvider.when('/', {
        template : 'some links',
        controller : 'DefaultController'
    });
});

app.controller('DefaultController', DefaultController);
app.controller('UserController',    UserController);

console.log('app.js');
