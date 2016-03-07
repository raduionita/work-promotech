var app = angular.module('app', ['ngRoute']);

var UserModel = function() {
    
};

var DefaultController = function($scope) {
    
};

var PromotionsController = function ($scope, $http) {
    var list = [];
    
    $http.get(Routing.generate('promo_angular_promotions_get')).success(function(response) {
        for (var i = 0, l = response.data.length; i < l; ++i) {
            var promotion = response.data[i];
            list.push(promotion);
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
    }).when('/promotions', {
        template : 'some links',
        controller : 'PromotionsController'
    });
});

app.controller('DefaultController',    DefaultController);
app.controller('PromotionsController', PromotionsController);

console.log('app.js');
