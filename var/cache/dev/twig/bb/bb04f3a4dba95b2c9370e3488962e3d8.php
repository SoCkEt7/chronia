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

/* job/edit.html.twig */
class __TwigTemplate_731312e8bd426e27d54393a452559230 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "job/edit.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "job/edit.html.twig"));

        $this->parent = $this->loadTemplate("base.html.twig", "job/edit.html.twig", 3);
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

        yield "Edit Cron Job - Chronia";
        
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
        yield "    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1>Edit Cron Job</h1>
        <div>
            <a href=\"";
        // line 11
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_job_index");
        yield "\" class=\"btn btn-secondary me-2\">
                <i class=\"bi bi-arrow-left\"></i> Back to List
            </a>
            <a href=\"";
        // line 14
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_job_test", ["id" => CoreExtension::getAttribute($this->env, $this->source, (isset($context["entry"]) || array_key_exists("entry", $context) ? $context["entry"] : (function () { throw new RuntimeError('Variable "entry" does not exist.', 14, $this->source); })()), "id", [], "any", false, false, false, 14)]), "html", null, true);
        yield "\" class=\"btn btn-info\">
                <i class=\"bi bi-play\"></i> Test Job
            </a>
        </div>
    </div>

    <div class=\"card\">
        <div class=\"card-header\">
            <h5>Job Details</h5>
        </div>
        <div class=\"card-body\">
            ";
        // line 25
        yield         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock((isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 25, $this->source); })()), 'form_start');
        yield "
                <div class=\"row\">
                    <div class=\"col-md-6\">
                        ";
        // line 28
        yield $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(CoreExtension::getAttribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 28, $this->source); })()), "schedule", [], "any", false, false, false, 28), 'row');
        yield "
                    </div>
                    <div class=\"col-md-6\">
                        ";
        // line 31
        yield $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(CoreExtension::getAttribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 31, $this->source); })()), "schedule_type", [], "any", false, false, false, 31), 'row');
        yield "
                    </div>
                </div>
                ";
        // line 34
        yield $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(CoreExtension::getAttribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 34, $this->source); })()), "command", [], "any", false, false, false, 34), 'row');
        yield "
                <div class=\"d-grid gap-2 mt-3\">
                    <button type=\"submit\" class=\"btn btn-primary\">Update Job</button>
                </div>
            ";
        // line 38
        yield         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock((isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 38, $this->source); })()), 'form_end');
        yield "
        </div>
    </div>

    <div class=\"mt-4\">
        <div class=\"card\">
            <div class=\"card-header\">
                <h5>Job Status</h5>
            </div>
            <div class=\"card-body\">
                <p>
                    <strong>Status:</strong>
                    ";
        // line 50
        if (CoreExtension::getAttribute($this->env, $this->source, (isset($context["entry"]) || array_key_exists("entry", $context) ? $context["entry"] : (function () { throw new RuntimeError('Variable "entry" does not exist.', 50, $this->source); })()), "active", [], "any", false, false, false, 50)) {
            // line 51
            yield "                        <span class=\"badge bg-success\">Active</span>
                    ";
        } else {
            // line 53
            yield "                        <span class=\"badge bg-secondary\">Inactive</span>
                    ";
        }
        // line 55
        yield "                </p>
                <p>
                    <strong>Last Run:</strong>
                    ";
        // line 58
        if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["entry"]) || array_key_exists("entry", $context) ? $context["entry"] : (function () { throw new RuntimeError('Variable "entry" does not exist.', 58, $this->source); })()), "last_run", [], "any", false, false, false, 58), "time", [], "any", false, false, false, 58)) {
            // line 59
            yield "                        ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["entry"]) || array_key_exists("entry", $context) ? $context["entry"] : (function () { throw new RuntimeError('Variable "entry" does not exist.', 59, $this->source); })()), "last_run", [], "any", false, false, false, 59), "time", [], "any", false, false, false, 59), "html", null, true);
            yield "
                        ";
            // line 60
            if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["entry"]) || array_key_exists("entry", $context) ? $context["entry"] : (function () { throw new RuntimeError('Variable "entry" does not exist.', 60, $this->source); })()), "last_run", [], "any", false, false, false, 60), "status", [], "any", false, false, false, 60)) {
                // line 61
                yield "                            <span class=\"badge bg-success\">Success</span>
                        ";
            } else {
                // line 63
                yield "                            <span class=\"badge bg-danger\">Failed</span>
                        ";
            }
            // line 65
            yield "                    ";
        } else {
            // line 66
            yield "                        <span class=\"text-muted\">Never run</span>
                    ";
        }
        // line 68
        yield "                </p>
                
                <div class=\"d-flex mt-3\">
                    ";
        // line 71
        if (CoreExtension::getAttribute($this->env, $this->source, (isset($context["entry"]) || array_key_exists("entry", $context) ? $context["entry"] : (function () { throw new RuntimeError('Variable "entry" does not exist.', 71, $this->source); })()), "active", [], "any", false, false, false, 71)) {
            // line 72
            yield "                        <a href=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_job_toggle", ["id" => CoreExtension::getAttribute($this->env, $this->source, (isset($context["entry"]) || array_key_exists("entry", $context) ? $context["entry"] : (function () { throw new RuntimeError('Variable "entry" does not exist.', 72, $this->source); })()), "id", [], "any", false, false, false, 72), "active" => 0]), "html", null, true);
            yield "\" class=\"btn btn-warning me-2\">
                            <i class=\"bi bi-pause-circle\"></i> Disable Job
                        </a>
                    ";
        } else {
            // line 76
            yield "                        <a href=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_job_toggle", ["id" => CoreExtension::getAttribute($this->env, $this->source, (isset($context["entry"]) || array_key_exists("entry", $context) ? $context["entry"] : (function () { throw new RuntimeError('Variable "entry" does not exist.', 76, $this->source); })()), "id", [], "any", false, false, false, 76), "active" => 1]), "html", null, true);
            yield "\" class=\"btn btn-success me-2\">
                            <i class=\"bi bi-play-circle\"></i> Enable Job
                        </a>
                    ";
        }
        // line 80
        yield "                    
                    <button type=\"button\" class=\"btn btn-danger\" data-bs-toggle=\"modal\" data-bs-target=\"#deleteModal\">
                        <i class=\"bi bi-trash\"></i> Delete Job
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Confirmation Modal -->
    <div class=\"modal fade\" id=\"deleteModal\" tabindex=\"-1\" aria-labelledby=\"deleteModalLabel\" aria-hidden=\"true\">
        <div class=\"modal-dialog\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <h5 class=\"modal-title\" id=\"deleteModalLabel\">Confirm Deletion</h5>
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
                </div>
                <div class=\"modal-body\">
                    <p>Are you sure you want to delete this cron job?</p>
                    <p><strong>Schedule:</strong> <code>";
        // line 99
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["entry"]) || array_key_exists("entry", $context) ? $context["entry"] : (function () { throw new RuntimeError('Variable "entry" does not exist.', 99, $this->source); })()), "schedule", [], "any", false, false, false, 99), "html", null, true);
        yield "</code></p>
                    <p><strong>Command:</strong> <code>";
        // line 100
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["entry"]) || array_key_exists("entry", $context) ? $context["entry"] : (function () { throw new RuntimeError('Variable "entry" does not exist.', 100, $this->source); })()), "command", [], "any", false, false, false, 100), "html", null, true);
        yield "</code></p>
                </div>
                <div class=\"modal-footer\">
                    <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cancel</button>
                    <form action=\"";
        // line 104
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_job_delete", ["id" => CoreExtension::getAttribute($this->env, $this->source, (isset($context["entry"]) || array_key_exists("entry", $context) ? $context["entry"] : (function () { throw new RuntimeError('Variable "entry" does not exist.', 104, $this->source); })()), "id", [], "any", false, false, false, 104)]), "html", null, true);
        yield "\" method=\"post\">
                        <input type=\"hidden\" name=\"_token\" value=\"";
        // line 105
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderCsrfToken(("delete" . CoreExtension::getAttribute($this->env, $this->source, (isset($context["entry"]) || array_key_exists("entry", $context) ? $context["entry"] : (function () { throw new RuntimeError('Variable "entry" does not exist.', 105, $this->source); })()), "id", [], "any", false, false, false, 105))), "html", null, true);
        yield "\">
                        <button type=\"submit\" class=\"btn btn-danger\">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        yield from [];
    }

    // line 114
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

        // line 115
        yield "<script>
    document.addEventListener('DOMContentLoaded', function() {
        const schedulePresets = document.querySelector('.schedule-presets');
        const scheduleField = document.querySelector('[name\$=\"[schedule]\"]');
        
        if (schedulePresets && scheduleField) {
            schedulePresets.addEventListener('change', function() {
                if (this.value !== 'custom') {
                    scheduleField.value = this.value;
                }
            });
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
        return "job/edit.html.twig";
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
        return array (  296 => 115,  283 => 114,  264 => 105,  260 => 104,  253 => 100,  249 => 99,  228 => 80,  220 => 76,  212 => 72,  210 => 71,  205 => 68,  201 => 66,  198 => 65,  194 => 63,  190 => 61,  188 => 60,  183 => 59,  181 => 58,  176 => 55,  172 => 53,  168 => 51,  166 => 50,  151 => 38,  144 => 34,  138 => 31,  132 => 28,  126 => 25,  112 => 14,  106 => 11,  101 => 8,  88 => 7,  65 => 5,  42 => 3,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{# templates/job/edit.html.twig #}

{% extends 'base.html.twig' %}

{% block title %}Edit Cron Job - Chronia{% endblock %}

{% block body %}
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1>Edit Cron Job</h1>
        <div>
            <a href=\"{{ path('app_job_index') }}\" class=\"btn btn-secondary me-2\">
                <i class=\"bi bi-arrow-left\"></i> Back to List
            </a>
            <a href=\"{{ path('app_job_test', {'id': entry.id}) }}\" class=\"btn btn-info\">
                <i class=\"bi bi-play\"></i> Test Job
            </a>
        </div>
    </div>

    <div class=\"card\">
        <div class=\"card-header\">
            <h5>Job Details</h5>
        </div>
        <div class=\"card-body\">
            {{ form_start(form) }}
                <div class=\"row\">
                    <div class=\"col-md-6\">
                        {{ form_row(form.schedule) }}
                    </div>
                    <div class=\"col-md-6\">
                        {{ form_row(form.schedule_type) }}
                    </div>
                </div>
                {{ form_row(form.command) }}
                <div class=\"d-grid gap-2 mt-3\">
                    <button type=\"submit\" class=\"btn btn-primary\">Update Job</button>
                </div>
            {{ form_end(form) }}
        </div>
    </div>

    <div class=\"mt-4\">
        <div class=\"card\">
            <div class=\"card-header\">
                <h5>Job Status</h5>
            </div>
            <div class=\"card-body\">
                <p>
                    <strong>Status:</strong>
                    {% if entry.active %}
                        <span class=\"badge bg-success\">Active</span>
                    {% else %}
                        <span class=\"badge bg-secondary\">Inactive</span>
                    {% endif %}
                </p>
                <p>
                    <strong>Last Run:</strong>
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
                </p>
                
                <div class=\"d-flex mt-3\">
                    {% if entry.active %}
                        <a href=\"{{ path('app_job_toggle', {'id': entry.id, 'active': 0}) }}\" class=\"btn btn-warning me-2\">
                            <i class=\"bi bi-pause-circle\"></i> Disable Job
                        </a>
                    {% else %}
                        <a href=\"{{ path('app_job_toggle', {'id': entry.id, 'active': 1}) }}\" class=\"btn btn-success me-2\">
                            <i class=\"bi bi-play-circle\"></i> Enable Job
                        </a>
                    {% endif %}
                    
                    <button type=\"button\" class=\"btn btn-danger\" data-bs-toggle=\"modal\" data-bs-target=\"#deleteModal\">
                        <i class=\"bi bi-trash\"></i> Delete Job
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Confirmation Modal -->
    <div class=\"modal fade\" id=\"deleteModal\" tabindex=\"-1\" aria-labelledby=\"deleteModalLabel\" aria-hidden=\"true\">
        <div class=\"modal-dialog\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <h5 class=\"modal-title\" id=\"deleteModalLabel\">Confirm Deletion</h5>
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
                        <button type=\"submit\" class=\"btn btn-danger\">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
{% endblock %}

{% block javascripts %}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const schedulePresets = document.querySelector('.schedule-presets');
        const scheduleField = document.querySelector('[name\$=\"[schedule]\"]');
        
        if (schedulePresets && scheduleField) {
            schedulePresets.addEventListener('change', function() {
                if (this.value !== 'custom') {
                    scheduleField.value = this.value;
                }
            });
        }
    });
</script>
{% endblock %}", "job/edit.html.twig", "/home/antonin/app/otherProjects/chronia/templates/job/edit.html.twig");
    }
}
