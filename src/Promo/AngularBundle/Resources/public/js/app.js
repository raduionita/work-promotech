var MainController = function($scope) {
    
};

var EditController = function($http) {
    /* Controller */ var self = this;            // private :)
    /* int */        this.id     = null;
    /* string */     this.label  = 'discount';
    /* string */     this.name   = '';
    /* string */     this.status = 'offline';

    (function(self) {
        $http.get(Routing.generate('promo_angular_promotions_id_get')).success(function(response) {
            for (var field in response.data) {
                if (response.data.hasOwnProperty(field)) {
                    self[field] = response.data[field];
                }
            }
        });
    })(this); // constructor
    
    this.save = function() /* void */ {
        console.log('Saving...');
    };
};

var ListController = function ($http) {
    /* array<object> */ var list = [];           // private :)
    /* Controller */    var self = this;         // private :)
    /* int */           this.id     = null;
    /* string */        this.label  = 'discount';
    /* string */        this.name   = '';
    /* string */        this.status = 'offline';

    (function(self) {
        $http.get(Routing.generate('promo_angular_promotions_get')).success(function(response) {
            for (var i = 0, l = response.data.length; i < l; ++i) {
                var promotion = response.data[i];
                list.push(promotion);
            }
        });
    })(this); // constructor
    
    this.add = function() /* -> void */ {
        if(self.label !== '') {
            list.push({ id: null, name: self.name, label: self.label, status: self.status});
            self.label  = 'discount';
            self.name   = '';
            self.status = 'offline';
        }
    };

    this.findOne = function(criteria) /* -> object */ {

    };

    this.findAll = function(criteria) /* -> array<object> */ {
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

    this.count = function(criteria) /* -> int */ {
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

var app = angular.module('app', ['ngRoute']);

app.config(function($interpolateProvider) {
    //$interpolateProvider.startSymbol('[[').endSymbol(']]');
});

app.config(function($routeProvider) {
    $routeProvider.when('/', {
        templateUrl: '/tpl/promoangular/default/view.html',
        controller : 'MainController'
    }).when('/promotions', {
        templateUrl: '/tpl/promoangular/promotions/list.html',
        controller : 'ListController'
    }).when('/promotions/:id', {
        templateUrl: '/tpl/promoangular/promotions/edit.html',
        controller : 'EditController'
    }).otherwise({
        template   : 'otherwise'
    });
});

app.controller('MainController', MainController);
app.controller('ListController', ListController);
app.controller('EditController', EditController);