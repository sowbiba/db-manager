var React = require('react');
var ReactDOM = require('react-dom');
var Provider = require('react-redux').Provider;

var Workspace = require('../components/workspace');

require('../stylesheets/index.css');

var workspace = document.getElementById('react-workspace');

var store = require('../store/factory')();

ReactDOM.render(<Provider store={ store }><Workspace /></Provider>, workspace);

var actions = require('../store/actions');

store.dispatch(actions.loadData());

console.log('ahhhh');
