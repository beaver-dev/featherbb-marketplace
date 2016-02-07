{% extends "layout.html" %}
{% block title %}Accueil | {% endblock %}

{% block content %}
    <h1>FeatherBB <small>Marketplace</small></h1>
    <div>a microframework for PHP</div>
{% if name %}
    <h3>Hello {{name}}!</h3>
{% else %}
    <p>Try <a href="{{ path_for('plugins', { 'name': 'SlimFramework' }) }}">/SlimFramework</a></p>
{% endif %}
{% endblock %}
