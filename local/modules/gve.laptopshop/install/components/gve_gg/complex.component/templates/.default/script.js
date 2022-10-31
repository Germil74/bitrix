if (typeof(BX.NewsListt) === 'undefined')
{
  BX.NewsListt = function(id)
  {
    this._id = id;
    this._settings = {};
    this._submitHandler = BX.delegate(this._clickHandler, this);
    BX.bind(BX(this._id + '_link'), 'click', this._submitHandler);
  };
  BX.NewsListt.prototype =
    {
      initialize: function(id, settings)
      {
        this._id = id;
        this._settings = settings;
      },

      getId: function()
      {
        return this._id;
      },
      _clickHandler: function(e)
      {
        e.preventDefault()
        console.log(e.target);
        BX.ajax.runComponentAction(this._settings.componentName, 'greet', {
          mode: 'class',
          signedParameters: this._settings.signedParameters, //вот способ для передачи параметров компоненту.
          data: {
            dateRequest: Date.now()
          }
        }).then(function (response) {
          console.log(response);
        }).catch(function (response) {
          console.log(response);
        });
      }
    };






  // Создание объекта
  BX.NewsListt.create = function(id, settings)
  {
    var _self = new BX.NewsListt(id);
    _self.initialize(id, settings);
    return _self;
  };

  // Паттерн одиночки Создание объекта
/*

  BX.NewsListt._self  = null;
  BX.NewsListt.create = function(id, settings)
  {
    if (!this._self) {
      this._self = new BX.NewsListt();
    }
    this._self.initialize(id, settings);
    return this._self;
  };

*/


}
