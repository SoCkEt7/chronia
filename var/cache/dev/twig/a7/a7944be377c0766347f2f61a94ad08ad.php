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

/* job/index.html.twig */
class __TwigTemplate_c5980bcb5007b595e45dc16da171dfc9 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "job/index.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "job/index.html.twig"));

        $this->parent = $this->loadTemplate("base.html.twig", "job/index.html.twig", 3);
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

        yield "Cron Jobs - Chronia";
        
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
        yield "    ";
        yield from $this->unwrap()->yieldBlock('javascripts', $context, $blocks);
        // line 31
        yield "    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1>Cron Jobs</h1>
        <a href=\"";
        // line 33
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_job_new");
        if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 33, $this->source); })()), "request", [], "any", false, false, false, 33), "query", [], "any", false, false, false, 33), "get", ["user"], "method", false, false, false, 33)) {
            yield "?user=";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 33, $this->source); })()), "request", [], "any", false, false, false, 33), "query", [], "any", false, false, false, 33), "get", ["user"], "method", false, false, false, 33), "html", null, true);
        }
        yield "\" class=\"btn btn-primary\">
            <i class=\"bi bi-plus-circle\"></i> Add New Job
        </a>
    </div>
    
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
                        <input type=\"text\" id=\"userInput\" name=\"user\" class=\"form-control\" placeholder=\"Enter username (e.g. ";
        // line 48
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((array_key_exists("default_crontab_user", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["default_crontab_user"]) || array_key_exists("default_crontab_user", $context) ? $context["default_crontab_user"] : (function () { throw new RuntimeError('Variable "default_crontab_user" does not exist.', 48, $this->source); })()), "antonin")) : ("antonin")), "html", null, true);
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
        // line 59
        if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 59, $this->source); })()), "request", [], "any", false, false, false, 59), "query", [], "any", false, false, false, 59), "get", ["user"], "method", false, false, false, 59)) {
            // line 60
            yield "    <div class=\"alert alert-info\">
        <i class=\"bi bi-info-circle\"></i> Currently managing crontab for user: <strong>";
            // line 61
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 61, $this->source); })()), "request", [], "any", false, false, false, 61), "query", [], "any", false, false, false, 61), "get", ["user"], "method", false, false, false, 61), "html", null, true);
            yield "</strong>
    </div>
    ";
        }
        // line 64
        yield "
    ";
        // line 65
        if (Twig\Extension\CoreExtension::testEmpty((isset($context["entries"]) || array_key_exists("entries", $context) ? $context["entries"] : (function () { throw new RuntimeError('Variable "entries" does not exist.', 65, $this->source); })()))) {
            // line 66
            yield "        <div class=\"alert alert-info\">
            <p>No cron jobs found. Click the \"Add New Job\" button to create your first job.</p>
        </div>
    ";
        } else {
            // line 70
            yield "        <div class=\"table-responsive\">
            <table class=\"table table-striped table-hover\">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Schedule</th>
                        <th>Command</th>
                        <th>Status</th>
                        <th>Last Run</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    ";
            // line 83
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable((isset($context["entries"]) || array_key_exists("entries", $context) ? $context["entries"] : (function () { throw new RuntimeError('Variable "entries" does not exist.', 83, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["entry"]) {
                // line 84
                yield "                        <tr>
                            <td>";
                // line 85
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["entry"], "id", [], "any", false, false, false, 85), "html", null, true);
                yield "</td>
                            <td><code>";
                // line 86
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["entry"], "schedule", [], "any", false, false, false, 86), "html", null, true);
                yield "</code></td>
                            <td><code>";
                // line 87
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["entry"], "command", [], "any", false, false, false, 87), "html", null, true);
                yield "</code></td>
                            <td>
                                ";
                // line 89
                if (CoreExtension::getAttribute($this->env, $this->source, $context["entry"], "active", [], "any", false, false, false, 89)) {
                    // line 90
                    yield "                                    <span class=\"badge bg-success\">Active</span>
                                ";
                } else {
                    // line 92
                    yield "                                    <span class=\"badge bg-secondary\">Inactive</span>
                                ";
                }
                // line 94
                yield "                            </td>
                            <td>
                                ";
                // line 96
                if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["entry"], "last_run", [], "any", false, false, false, 96), "time", [], "any", false, false, false, 96)) {
                    // line 97
                    yield "                                    ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["entry"], "last_run", [], "any", false, false, false, 97), "time", [], "any", false, false, false, 97), "html", null, true);
                    yield "
                                    ";
                    // line 98
                    if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["entry"], "last_run", [], "any", false, false, false, 98), "status", [], "any", false, false, false, 98)) {
                        // line 99
                        yield "                                        <span class=\"badge bg-success\">Success</span>
                                    ";
                    } else {
                        // line 101
                        yield "                                        <span class=\"badge bg-danger\">Failed</span>
                                    ";
                    }
                    // line 103
                    yield "                                ";
                } else {
                    // line 104
                    yield "                                    <span class=\"text-muted\">Never run</span>
                                ";
                }
                // line 106
                yield "                            </td>
                            <td>
                                <div class=\"btn-group\">
                                    <a href=\"";
                // line 109
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_job_edit", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["entry"], "id", [], "any", false, false, false, 109)]), "html", null, true);
                if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 109, $this->source); })()), "request", [], "any", false, false, false, 109), "query", [], "any", false, false, false, 109), "get", ["user"], "method", false, false, false, 109)) {
                    yield "?user=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 109, $this->source); })()), "request", [], "any", false, false, false, 109), "query", [], "any", false, false, false, 109), "get", ["user"], "method", false, false, false, 109), "html", null, true);
                }
                yield "\" class=\"btn btn-sm btn-outline-primary\">Edit</a>
                                    <a href=\"";
                // line 110
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_job_test", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["entry"], "id", [], "any", false, false, false, 110)]), "html", null, true);
                if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 110, $this->source); })()), "request", [], "any", false, false, false, 110), "query", [], "any", false, false, false, 110), "get", ["user"], "method", false, false, false, 110)) {
                    yield "?user=";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 110, $this->source); })()), "request", [], "any", false, false, false, 110), "query", [], "any", false, false, false, 110), "get", ["user"], "method", false, false, false, 110), "html", null, true);
                }
                yield "\" class=\"btn btn-sm btn-outline-secondary\">Test</a>
                                    ";
                // line 111
                if (CoreExtension::getAttribute($this->env, $this->source, $context["entry"], "active", [], "any", false, false, false, 111)) {
                    // line 112
                    yield "                                        <a href=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_job_toggle", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["entry"], "id", [], "any", false, false, false, 112), "active" => 0]), "html", null, true);
                    if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 112, $this->source); })()), "request", [], "any", false, false, false, 112), "query", [], "any", false, false, false, 112), "get", ["user"], "method", false, false, false, 112)) {
                        yield "?user=";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 112, $this->source); })()), "request", [], "any", false, false, false, 112), "query", [], "any", false, false, false, 112), "get", ["user"], "method", false, false, false, 112), "html", null, true);
                    }
                    yield "\" class=\"btn btn-sm btn-outline-warning\">Disable</a>
                                    ";
                } else {
                    // line 114
                    yield "                                        <a href=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_job_toggle", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["entry"], "id", [], "any", false, false, false, 114), "active" => 1]), "html", null, true);
                    if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 114, $this->source); })()), "request", [], "any", false, false, false, 114), "query", [], "any", false, false, false, 114), "get", ["user"], "method", false, false, false, 114)) {
                        yield "?user=";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 114, $this->source); })()), "request", [], "any", false, false, false, 114), "query", [], "any", false, false, false, 114), "get", ["user"], "method", false, false, false, 114), "html", null, true);
                    }
                    yield "\" class=\"btn btn-sm btn-outline-success\">Enable</a>
                                    ";
                }
                // line 116
                yield "                                    <button type=\"button\" class=\"btn btn-sm btn-outline-danger\" data-bs-toggle=\"modal\" data-bs-target=\"#deleteModal";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["entry"], "id", [], "any", false, false, false, 116), "html", null, true);
                yield "\">Delete</button>
                                </div>
                                
                                <!-- Delete Confirmation Modal -->
                                <div class=\"modal fade\" id=\"deleteModal";
                // line 120
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["entry"], "id", [], "any", false, false, false, 120), "html", null, true);
                yield "\" tabindex=\"-1\" aria-labelledby=\"deleteModalLabel";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["entry"], "id", [], "any", false, false, false, 120), "html", null, true);
                yield "\" aria-hidden=\"true\">
                                    <div class=\"modal-dialog\">
                                        <div class=\"modal-content\">
                                            <div class=\"modal-header\">
                                                <h5 class=\"modal-title\" id=\"deleteModalLabel";
                // line 124
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["entry"], "id", [], "any", false, false, false, 124), "html", null, true);
                yield "\">Confirm Deletion</h5>
                                                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
                                            </div>
                                            <div class=\"modal-body\">
                                                <p>Are you sure you want to delete this cron job?</p>
                                                <p><strong>Schedule:</strong> <code>";
                // line 129
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["entry"], "schedule", [], "any", false, false, false, 129), "html", null, true);
                yield "</code></p>
                                                <p><strong>Command:</strong> <code>";
                // line 130
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["entry"], "command", [], "any", false, false, false, 130), "html", null, true);
                yield "</code></p>
                                            </div>
                                            <div class=\"modal-footer\">
                                                <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cancel</button>
                                                <form action=\"";
                // line 134
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_job_delete", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["entry"], "id", [], "any", false, false, false, 134)]), "html", null, true);
                yield "\" method=\"post\">
                                                    <input type=\"hidden\" name=\"_token\" value=\"";
                // line 135
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderCsrfToken(("delete" . CoreExtension::getAttribute($this->env, $this->source, $context["entry"], "id", [], "any", false, false, false, 135))), "html", null, true);
                yield "\">
                                                    ";
                // line 136
                if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 136, $this->source); })()), "request", [], "any", false, false, false, 136), "query", [], "any", false, false, false, 136), "get", ["user"], "method", false, false, false, 136)) {
                    // line 137
                    yield "                                                    <input type=\"hidden\" name=\"user\" value=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 137, $this->source); })()), "request", [], "any", false, false, false, 137), "query", [], "any", false, false, false, 137), "get", ["user"], "method", false, false, false, 137), "html", null, true);
                    yield "\">
                                                    ";
                }
                // line 139
                yield "                                                    <button type=\"submit\" class=\"btn btn-danger\">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['entry'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 148
            yield "                </tbody>
            </table>
        </div>
    ";
        }
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        yield from [];
    }

    // line 8
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

        // line 9
        yield "    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle the user selection form submission
            const userSelectionForm = document.getElementById('userSelectionForm');
            userSelectionForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const user = document.getElementById('userInput').value.trim();
                if (user) {
                    window.location.href = '";
        // line 17
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_job_index");
        yield "?user=' + encodeURIComponent(user);
                } else {
                    window.location.href = '";
        // line 19
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_job_index");
        yield "';
                }
            });
            
            // Pre-populate the user input field with the current query parameter
            const currentUser = '";
        // line 24
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 24, $this->source); })()), "request", [], "any", false, false, false, 24), "query", [], "any", false, false, false, 24), "get", ["user"], "method", false, false, false, 24), "html", null, true);
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
        return "job/index.html.twig";
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
        return array (  399 => 24,  391 => 19,  386 => 17,  376 => 9,  363 => 8,  348 => 148,  334 => 139,  328 => 137,  326 => 136,  322 => 135,  318 => 134,  311 => 130,  307 => 129,  299 => 124,  290 => 120,  282 => 116,  272 => 114,  262 => 112,  260 => 111,  252 => 110,  244 => 109,  239 => 106,  235 => 104,  232 => 103,  228 => 101,  224 => 99,  222 => 98,  217 => 97,  215 => 96,  211 => 94,  207 => 92,  203 => 90,  201 => 89,  196 => 87,  192 => 86,  188 => 85,  185 => 84,  181 => 83,  166 => 70,  160 => 66,  158 => 65,  155 => 64,  149 => 61,  146 => 60,  144 => 59,  130 => 48,  108 => 33,  104 => 31,  101 => 8,  88 => 7,  65 => 5,  42 => 3,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{# templates/job/index.html.twig #}

{% extends 'base.html.twig' %}

{% block title %}Cron Jobs - Chronia{% endblock %}

{% block body %}
    {% block javascripts %}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle the user selection form submission
            const userSelectionForm = document.getElementById('userSelectionForm');
            userSelectionForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const user = document.getElementById('userInput').value.trim();
                if (user) {
                    window.location.href = '{{ path('app_job_index') }}?user=' + encodeURIComponent(user);
                } else {
                    window.location.href = '{{ path('app_job_index') }}';
                }
            });
            
            // Pre-populate the user input field with the current query parameter
            const currentUser = '{{ app.request.query.get('user') }}';
            if (currentUser) {
                document.getElementById('userInput').value = currentUser;
            }
        });
    </script>
    {% endblock %}
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1>Cron Jobs</h1>
        <a href=\"{{ path('app_job_new') }}{% if app.request.query.get('user') %}?user={{ app.request.query.get('user') }}{% endif %}\" class=\"btn btn-primary\">
            <i class=\"bi bi-plus-circle\"></i> Add New Job
        </a>
    </div>
    
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
        <i class=\"bi bi-info-circle\"></i> Currently managing crontab for user: <strong>{{ app.request.query.get('user') }}</strong>
    </div>
    {% endif %}

    {% if entries is empty %}
        <div class=\"alert alert-info\">
            <p>No cron jobs found. Click the \"Add New Job\" button to create your first job.</p>
        </div>
    {% else %}
        <div class=\"table-responsive\">
            <table class=\"table table-striped table-hover\">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Schedule</th>
                        <th>Command</th>
                        <th>Status</th>
                        <th>Last Run</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {% for entry in entries %}
                        <tr>
                            <td>{{ entry.id }}</td>
                            <td><code>{{ entry.schedule }}</code></td>
                            <td><code>{{ entry.command }}</code></td>
                            <td>
                                {% if entry.active %}
                                    <span class=\"badge bg-success\">Active</span>
                                {% else %}
                                    <span class=\"badge bg-secondary\">Inactive</span>
                                {% endif %}
                            </td>
                            <td>
                                {% if entry.last_run.time %}
                                    {{ entry.last_run.time }}
                                    {% if entry.last_run.status %}
                                        <span class=\"badge bg-success\">Success</span>
                                    {% else %}
                                        <span class=\"badge bg-danger\">Failed</span>
                                    {% endif %}
                                {% else %}
                                    <span class=\"text-muted\">Never run</span>
                                {% endif %}
                            </td>
                            <td>
                                <div class=\"btn-group\">
                                    <a href=\"{{ path('app_job_edit', {'id': entry.id}) }}{% if app.request.query.get('user') %}?user={{ app.request.query.get('user') }}{% endif %}\" class=\"btn btn-sm btn-outline-primary\">Edit</a>
                                    <a href=\"{{ path('app_job_test', {'id': entry.id}) }}{% if app.request.query.get('user') %}?user={{ app.request.query.get('user') }}{% endif %}\" class=\"btn btn-sm btn-outline-secondary\">Test</a>
                                    {% if entry.active %}
                                        <a href=\"{{ path('app_job_toggle', {'id': entry.id, 'active': 0}) }}{% if app.request.query.get('user') %}?user={{ app.request.query.get('user') }}{% endif %}\" class=\"btn btn-sm btn-outline-warning\">Disable</a>
                                    {% else %}
                                        <a href=\"{{ path('app_job_toggle', {'id': entry.id, 'active': 1}) }}{% if app.request.query.get('user') %}?user={{ app.request.query.get('user') }}{% endif %}\" class=\"btn btn-sm btn-outline-success\">Enable</a>
                                    {% endif %}
                                    <button type=\"button\" class=\"btn btn-sm btn-outline-danger\" data-bs-toggle=\"modal\" data-bs-target=\"#deleteModal{{ entry.id }}\">Delete</button>
                                </div>
                                
                                <!-- Delete Confirmation Modal -->
                                <div class=\"modal fade\" id=\"deleteModal{{ entry.id }}\" tabindex=\"-1\" aria-labelledby=\"deleteModalLabel{{ entry.id }}\" aria-hidden=\"true\">
                                    <div class=\"modal-dialog\">
                                        <div class=\"modal-content\">
                                            <div class=\"modal-header\">
                                                <h5 class=\"modal-title\" id=\"deleteModalLabel{{ entry.id }}\">Confirm Deletion</h5>
                                                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
                                            </div>
                                            <div class=\"modal-body\">
                                                <p>Are you sure you want to delete this cron job?</p>
                                                <p><strong>Schedule:</strong> <code>{{ entry.schedule }}</code></p>
                                                <p><strong>Command:</strong> <code>{{ entry.command }}</code></p>
                                            </div>
                                            <div class=\"modal-footer\">
                                                <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cancel</button>
                                                <form action=\"{{ path('app_job_delete', {'id': entry.id}) }}\" method=\"post\">
                                                    <input type=\"hidden\" name=\"_token\" value=\"{{ csrf_token('delete' ~ entry.id) }}\">
                                                    {% if app.request.query.get('user') %}
                                                    <input type=\"hidden\" name=\"user\" value=\"{{ app.request.query.get('user') }}\">
                                                    {% endif %}
                                                    <button type=\"submit\" class=\"btn btn-danger\">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    {% endfor %}
                </tbody>
            </table>
        </div>
    {% endif %}
{% endblock %}", "job/index.html.twig", "/home/antonin/app/otherProjects/chronia/templates/job/index.html.twig");
    }
}
