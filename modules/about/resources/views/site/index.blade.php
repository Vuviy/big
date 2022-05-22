@extends('cms-ui::layouts.about')

@php
    /**
     * @var $siteSettings array
     */
@endphp

@section('content')
   <div class="about _pb-lg _df:pb-xxl">
       <div class="about-banner">
           @widget('ui:breadcrumbs', ['containerModification' => $containerModification ?? null])
           <img src="{{ asset('/images/about/banner-bg.jpg') }}" alt="" class="about-banner__image">
           <img src="{{ asset('/images/about/banner-decor.svg') }}" alt="" class="about-banner__decor">
           <div class="about-banner__content">
               <div class="container container--def _flex _flex-column _items-center">
                   @svg('common', 'logo')
                   <div class="about-banner__text">
                       @if(!empty($siteSettings['content_banner_title']))
                           {{ $siteSettings['content_banner_title'] }}
                       @endif
                   </div>
               </div>
           </div>
       </div>
       <div class="container container--def">
           <div class="_md:py-lg _my-df _md:my-lg">
               @if(!empty($siteSettings['description_under_heading']))
                   {!! $siteSettings['description_under_heading'] !!}
               @endif
           </div>
       </div>
       <div class="container">
           @widget('about:our-products')
       </div>
       @widget('benefits:benefits', ['type' => \WezomCms\Benefits\Enums\BenefitsTypes::ABOUT_1, 'limit' => 6], 'cms-benefits::site.widgets.benefits.about_1')
       <div class="container container--md">
          @widget('about:event-history')
       </div>
       <div class="container container--lg">
           @widget('about:our-team')
       </div>
       @widget('benefits:benefits', ['type' => \WezomCms\Benefits\Enums\BenefitsTypes::ABOUT_2, 'limit' => 3], 'cms-benefits::site.widgets.benefits.about_2')
       @widget('about:reviews')
   </div>
@endsection
