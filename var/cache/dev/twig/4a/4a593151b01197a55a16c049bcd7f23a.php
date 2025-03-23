<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* dashboard/index.html.twig */
class __TwigTemplate_bc3215635fcce01aa7958c8face2d555 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
            'javascripts' => [$this, 'block_javascripts'],
        ];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 3
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "dashboard/index.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "dashboard/index.html.twig"));

        $this->parent = $this->loadTemplate("base.html.twig", "dashboard/index.html.twig", 3);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

    }

    // line 5
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        yield "Dashboard - Chronia";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        yield from [];
    }

    // line 7
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_body(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 8
        yield "    <!-- User selection form -->
    <div class=\"card mb-4\">
        <div class=\"card-header bg-light\">
            <h5 class=\"mb-0\">Select User</h5>
        </div>
        <div class=\"card-body\">
            <form id=\"userSelectionForm\" class=\"d-flex gap-2\">
                <div class=\"flex-grow-1\">
                    <div class=\"input-group\">
                        <span class=\"input-group-text\">User:</span>
                        <input type=\"text\" id=\"userInput\" name=\"user\" class=\"form-control\" placeholder=\"Enter username (e.g. ";
        // line 18
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((array_key_exists("default_crontab_user", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["default_crontab_user"]) || array_key_exists("default_crontab_user", $context) ? $context["default_crontab_user"] : (function () { throw new RuntimeError('Variable "default_crontab_user" does not exist.', 18, $this->source); })()), "antonin")) : ("antonin")), "html", null, true);
        yield ")\">
                    </div>
                    <small class=\"form-text text-muted\">Enter a username to view and manage their crontab</small>
                </div>
                <div>
                    <button type=\"submit\" class=\"btn btn-primary\">Load Jobs</button>
                </div>
            </form>
        </div>
    </div>
    
    ";
        // line 29
        if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 29, $this->source); })()), "request", [], "any", false, false, false, 29), "query", [], "any", false, false, false, 29), "get", ["user"], "method", false, false, false, 29)) {
            // line 30
            yield "    <div class=\"alert alert-info\">
        <i class=\"bi bi-info-circle\"></i> Currently viewing crontab for user: <strong>";
            // line 31
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 31, $this->source); })()), "request", [], "any", false, false, false, 31), "query", [], "any", false, false, false, 31), "get", ["user"], "method", false, false, false, 31), "html", null, true);
            yield "</strong>
    </div>
    ";
        }
        // line 34
        yield "    <h1>Dashboard</h1>
    
    <div class=\"row mt-4\">
        <div class=\"col-md-4\">
            <div class=\"card text-white bg-primary mb-3\">
                <div class=\"card-header\">Active Jobs</div>
                <div class=\"card-body\">
                    <h2 class=\"card-title\">";
        // line 41
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["active_count"]) || array_key_exists("active_count", $context) ? $context["active_count"] : (function () { throw new RuntimeError('Variable "active_count" does not exist.', 41, $this->source); })()), "html", null, true);
        yield "</h2>
                    <p class=\"card-text\">Currently active cron jobs</p>
                </div>
            </div>
        </div>
        <div class=\"col-md-4\">
            <div class=\"card text-white bg-secondary mb-3\">
                <div class=\"card-header\">Total Jobs</div>
                <div class=\"card-body\">
                    <h2 class=\"card-title\">";
        // line 50
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["total_count"]) || array_key_exists("total_count", $context) ? $context["total_count"] : (function () { throw new RuntimeError('Variable "total_count" does not exist.', 50, $this->source); })()), "html", null, true);
        yield "</h2>
                    <p class=\"card-text\">Total configured cron jobs</p>
                </div>
            </div>
        </div>
        <div class=\"col-md-4\">
            <div class=\"card ";
        // line 56
        if (CoreExtension::getAttribute($this->env, $this->source, (isset($context["system_status"]) || array_key_exists("system_status", $context) ? $context["system_status"] : (function () { throw new RuntimeError('Variable "system_status" does not exist.', 56, $this->source); })()), "cron_running", [], "any", false, false, false, 56)) {
            yield "text-white bg-success";
        } else {
            yield "text-white bg-danger";
        }
        yield " mb-3\">
                <div class=\"card-header\">Cron Service</div>
                <div class=\"card-body\">
                    <h2 class=\"card-title\">";
        // line 59
        yield ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["system_status"]) || array_key_exists("system_status", $context) ? $context["system_status"] : (function () { throw new RuntimeError('Variable "system_status" does not exist.', 59, $this->source); })()), "cron_running", [], "any", false, false, false, 59)) ? ("Running") : ("Stopped"));
        yield "</h2>
                    <p class=\"card-text\">";
        // line 60
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["system_status"]) || array_key_exists("system_status", $context) ? $context["system_status"] : (function () { throw new RuntimeError('Variable "system_status" does not exist.', 60, $this->source); })()), "cron_service", [], "any", false, false, false, 60), "html", null, true);
        yield "</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class=\"row mt-4\">
        <div class=\"col-md-6\">
            <div class=\"card mb-3\">
                <div class=\"card-header\">
                    <h5>Upcoming Jobs</h5>
                </div>
                <div class=\"card-body\">
                    ";
        // line 73
        if (Twig\Extension\CoreExtension::testEmpty((isset($context["upcoming_jobs"]) || array_key_exists("upcoming_jobs", $context) ? $context["upcoming_jobs"] : (function () { throw new RuntimeError('Variable "upcoming_jobs" does not exist.', 73, $this->source); })()))) {
            // line 74
            yield "                        <p class=\"text-muted\">No upcoming jobs</p>
                    ";
        } else {
            // line 76
            yield "                        <div class=\"list-group\">
                            ";
            // line 77
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable((isset($context["upcoming_jobs"]) || array_key_exists("upcoming_jobs", $context) ? $context["upcoming_jobs"] : (function () { throw new RuntimeError('Variable "upcoming_jobs" does not exist.', 77, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["job"]) {
                // line 78
                yield "                                <a href=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_job_edit", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["job"], "id", [], "any", false, false, false, 78)]), "html", null, true);
                yield "\" class=\"list-group-item list-group-item-action\">
                                    <div class=\"d-flex w-100 justify-content-between\">
                                        <h6 class=\"mb-1\">";
                // line 80
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["job"], "command", [], "any", false, false, false, 80), "html", null, true);
                yield "</h6>
                                        <small>";
                // line 81
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["job"], "next_run", [], "any", false, false, false, 81), "Y-m-d H:i:s"), "html", null, true);
                yield "</small>
                                    </div>
                                </a>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['job'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 85
            yield "                        </div>
                    ";
        }
        // line 87
        yield "                </div>
            </div>
        </div>
        
        <div class=\"col-md-6\">
            <div class=\"card mb-3\">
                <div class=\"card-header\">
                    <h5>System Information</h5>
                </div>
                <div class=\"card-body\">
                    <ul class=\"list-group\">
                        <li class=\"list-group-item d-flex justify-content-between align-items-center\">
                            Environment
                            <span class=\"badge ";
        // line 100
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["system_status"]) || array_key_exists("system_status", $context) ? $context["system_status"] : (function () { throw new RuntimeError('Variable "system_status" does not exist.', 100, $this->source); })()), "environment", [], "any", false, false, false, 100) == "dev")) {
            yield "bg-warning";
        } else {
            yield "bg-info";
        }
        yield "\">
                                ";
        // line 101
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["system_status"]) || array_key_exists("system_status", $context) ? $context["system_status"] : (function () { throw new RuntimeError('Variable "system_status" does not exist.', 101, $this->source); })()), "environment", [], "any", false, false, false, 101), "html", null, true);
        yield "
                            </span>
                        </li>
                        <li class=\"list-group-item d-flex justify-content-between align-items-center\">
                            Platform
                            <span class=\"badge bg-info\">";
        // line 106
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["system_status"]) || array_key_exists("system_status", $context) ? $context["system_status"] : (function () { throw new RuntimeError('Variable "system_status" does not exist.', 106, $this->source); })()), "platform", [], "any", false, false, false, 106), "platform", [], "any", false, false, false, 106), "html", null, true);
        yield "</span>
                        </li>
                        <li class=\"list-group-item d-flex justify-content-between align-items-center\">
                            Cron Service
                            <span class=\"badge ";
        // line 110
        if (CoreExtension::getAttribute($this->env, $this->source, (isset($context["system_status"]) || array_key_exists("system_status", $context) ? $context["system_status"] : (function () { throw new RuntimeError('Variable "system_status" does not exist.', 110, $this->source); })()), "cron_running", [], "any", false, false, false, 110)) {
            yield "bg-success";
        } else {
            yield "bg-danger";
        }
        yield "\">
                                ";
        // line 111
        yield ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["system_status"]) || array_key_exists("system_status", $context) ? $context["system_status"] : (function () { throw new RuntimeError('Variable "system_status" does not exist.', 111, $this->source); })()), "cron_running", [], "any", false, false, false, 111)) ? ("Running") : ("Stopped"));
        yield "
                            </span>
                        </li>
                        <li class=\"list-group-item d-flex justify-content-between align-items-center\">
                            Utilisateur Crontab
                            <span class=\"badge bg-info\">";
        // line 116
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["system_status"]) || array_key_exists("system_status", $context) ? $context["system_status"] : (function () { throw new RuntimeError('Variable "system_status" does not exist.', 116, $this->source); })()), "user", [], "any", false, false, false, 116), "html", null, true);
        yield "</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <div class=\"row mt-3\">
        <div class=\"col\">
            <div class=\"d-grid gap-2\">
                <a href=\"";
        // line 127
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_job_index");
        if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 127, $this->source); })()), "request", [], "any", false, false, false, 127), "query", [], "any", false, false, false, 127), "get", ["user"], "method", false, false, false, 127)) {
            yield "?user=";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 127, $this->source); })()), "request", [], "any", false, false, false, 127), "query", [], "any", false, false, false, 127), "get", ["user"], "method", false, false, false, 127), "html", null, true);
        }
        yield "\" class=\"btn btn-primary\">Manage Cron Jobs</a>
            </div>
        </div>
    </div>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        yield from [];
    }

    // line 133
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_javascripts(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "javascripts"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "javascripts"));

        // line 134
        yield "<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle the user selection form submission
        const userSelectionForm = document.getElementById('userSelectionForm');
        userSelectionForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const user = document.getElementById('userInput').value.trim();
            if (user) {
                window.location.href = '";
        // line 142
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_dashboard");
        yield "?user=' + encodeURIComponent(user);
            } else {
                window.location.href = '";
        // line 144
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_dashboard");
        yield "';
            }
        });
        
        // Pre-populate the user input field with the current query parameter
        const currentUser = '";
        // line 149
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 149, $this->source); })()), "request", [], "any", false, false, false, 149), "query", [], "any", false, false, false, 149), "get", ["user"], "method", false, false, false, 149), "html", null, true);
        yield "';
        if (currentUser) {
            document.getElementById('userInput').value = currentUser;
        }
    });
</script>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "dashboard/index.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  359 => 149,  351 => 144,  346 => 142,  336 => 134,  323 => 133,  303 => 127,  289 => 116,  281 => 111,  273 => 110,  266 => 106,  258 => 101,  250 => 100,  235 => 87,  231 => 85,  221 => 81,  217 => 80,  211 => 78,  207 => 77,  204 => 76,  200 => 74,  198 => 73,  182 => 60,  178 => 59,  168 => 56,  159 => 50,  147 => 41,  138 => 34,  132 => 31,  129 => 30,  127 => 29,  113 => 18,  101 => 8,  88 => 7,  65 => 5,  42 => 3,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{# templates/dashboard/index.html.twig #}

{% extends 'base.html.twig' %}

{% block title %}Dashboard - Chronia{% endblock %}

{% block body %}
    <!-- User selection form -->
    <div class=\"card mb-4\">
        <div class=\"card-header bg-light\">
            <h5 class=\"mb-0\">Select User</h5>
        </div>
        <div class=\"card-body\">
            <form id=\"userSelectionForm\" class=\"d-flex gap-2\">
                <div class=\"flex-grow-1\">
                    <div class=\"input-group\">
                        <span class=\"input-group-text\">User:</span>
                        <input type=\"text\" id=\"userInput\" name=\"user\" class=\"form-control\" placeholder=\"Enter username (e.g. {{ default_crontab_user|default('antonin') }})\">
                    </div>
                    <small class=\"form-text text-muted\">Enter a username to view and manage their crontab</small>
                </div>
                <div>
                    <button type=\"submit\" class=\"btn btn-primary\">Load Jobs</button>
                </div>
            </form>
        </div>
    </div>
    
    {% if app.request.query.get('user') %}
    <div class=\"alert alert-info\">
        <i class=\"bi bi-info-circle\"></i> Currently viewing crontab for user: <strong>{{ app.request.query.get('user') }}</strong>
    </div>
    {% endif %}
    <h1>Dashboard</h1>
    
    <div class=\"row mt-4\">
        <div class=\"col-md-4\">
            <div class=\"card text-white bg-primary mb-3\">
                <div class=\"card-header\">Active Jobs</div>
                <div class=\"card-body\">
                    <h2 class=\"card-title\">{{ active_count }}</h2>
                    <p class=\"card-text\">Currently active cron jobs</p>
                </div>
            </div>
        </div>
        <div class=\"col-md-4\">
            <div class=\"card text-white bg-secondary mb-3\">
                <div class=\"card-header\">Total Jobs</div>
                <div class=\"card-body\">
                    <h2 class=\"card-title\">{{ total_count }}</h2>
                    <p class=\"card-text\">Total configured cron jobs</p>
                </div>
            </div>
        </div>
        <div class=\"col-md-4\">
            <div class=\"card {% if system_status.cron_running %}text-white bg-success{% else %}text-white bg-danger{% endif %} mb-3\">
                <div class=\"card-header\">Cron Service</div>
                <div class=\"card-body\">
                    <h2 class=\"card-title\">{{ system_status.cron_running ? 'Running' : 'Stopped' }}</h2>
                    <p class=\"card-text\">{{ system_status.cron_service }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class=\"row mt-4\">
        <div class=\"col-md-6\">
            <div class=\"card mb-3\">
                <div class=\"card-header\">
                    <h5>Upcoming Jobs</h5>
                </div>
                <div class=\"card-body\">
                    {% if upcoming_jobs is empty %}
                        <p class=\"text-muted\">No upcoming jobs</p>
                    {% else %}
                        <div class=\"list-group\">
                            {% for job in upcoming_jobs %}
                                <a href=\"{{ path('app_job_edit', {'id': job.id}) }}\" class=\"list-group-item list-group-item-action\">
                                    <div class=\"d-flex w-100 justify-content-between\">
                                        <h6 class=\"mb-1\">{{ job.command }}</h6>
                                        <small>{{ job.next_run|date('Y-m-d H:i:s') }}</small>
                                    </div>
                                </a>
                            {% endfor %}
                        </div>
                    {% endif %}
                </div>
            </div>
        </div>
        
        <div class=\"col-md-6\">
            <div class=\"card mb-3\">
                <div class=\"card-header\">
                    <h5>System Information</h5>
                </div>
                <div class=\"card-body\">
                    <ul class=\"list-group\">
                        <li class=\"list-group-item d-flex justify-content-between align-items-center\">
                            Environment
                            <span class=\"badge {% if system_status.environment == 'dev' %}bg-warning{% else %}bg-info{% endif %}\">
                                {{ system_status.environment }}
                            </span>
                        </li>
                        <li class=\"list-group-item d-flex justify-content-between align-items-center\">
                            Platform
                            <span class=\"badge bg-info\">{{ system_status.platform.platform }}</span>
                        </li>
                        <li class=\"list-group-item d-flex justify-content-between align-items-center\">
                            Cron Service
                            <span class=\"badge {% if system_status.cron_running %}bg-success{% else %}bg-danger{% endif %}\">
                                {{ system_status.cron_running ? 'Running' : 'Stopped' }}
                            </span>
                        </li>
                        <li class=\"list-group-item d-flex justify-content-between align-items-center\">
                            Utilisateur Crontab
                            <span class=\"badge bg-info\">{{ system_status.user }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <div class=\"row mt-3\">
        <div class=\"col\">
            <div class=\"d-grid gap-2\">
                <a href=\"{{ path('app_job_index') }}{% if app.request.query.get('user') %}?user={{ app.request.query.get('user') }}{% endif %}\" class=\"btn btn-primary\">Manage Cron Jobs</a>
            </div>
        </div>
    </div>
{% endblock %}

{% block javascripts %}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle the user selection form submission
        const userSelectionForm = document.getElementById('userSelectionForm');
        userSelectionForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const user = document.getElementById('userInput').value.trim();
            if (user) {
                window.location.href = '{{ path('app_dashboard') }}?user=' + encodeURIComponent(user);
            } else {
                window.location.href = '{{ path('app_dashboard') }}';
            }
        });
        
        // Pre-populate the user input field with the current query parameter
        const currentUser = '{{ app.request.query.get('user') }}';
        if (currentUser) {
            document.getElementById('userInput').value = currentUser;
        }
    });
</script>
{% endblock %}", "dashboard/index.html.twig", "/home/antonin/app/otherProjects/chronia/templates/dashboard/index.html.twig");
    }
}
