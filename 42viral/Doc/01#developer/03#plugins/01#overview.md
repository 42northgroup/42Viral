# Plug-ins Overview

The 42Viral project makes extensive use of the CakePHP plug-in architecture to provide higher flexibility. These include
both 3rd party plug-ins as well as open source plug-ins developed by the 42Viral core team hosted on GitHub.

## [AssetManager](/docs/developer-plugins-asset_manager)
Streamlines the task of combining and compressing JS and CSS resources.

## [AuditLog](/docs/developer-plugins-audit_log)
Creates an audit history for each instance of a model to which it's attached. AuditLog tracks changes on two levels. It 
takes a snapshot of the fully hydrated object _after_ a change is complete and it also records each individual change in 
the case of an update action.

## [CalendarRecurssion](/docs/developer-plugins-calendar_recurssion)
This plug-in can be used to quickly generate date/time instances for a given range of dates with parameters such as
which days of the week you want the dates to be generated for. This becomes very useful in calendaring applications
for generating and blocking out dates on a calendar.

## [Connect](/docs/developer-plugins-connect)
Provides a model layer for various APIs.

## [ContentFilters](/docs/developer-plugins-content_filters)
Provides an API for purifying user submitted input using native PHP and wrapper classes for HTMLPurifier &amp; Akismet.

## [FileUpload](/docs/developer-plugins-file_upload)
Used to upload files through HTML forms with different settings which determine where the files will be saved, allowable
file types, file upload model, etc.

## [HtmlFromDoc](/docs/developer-plugins-html_from_doc)
Used to convert `.docx` files to their HTML equivalent, primarily used for content management.

## [Migrations](/docs/developer-plugins-migrations)
As an application is developed, changes to the database may be required, and managing that in teams can get extremely 
difficult. Migrations enables you to share and co-ordinate database changes in an iterative manner, removing the 
complexity of handling these changes.

## [PicklistManager](/docs/developer-plugins-picklist_manager)
An easy way to generate and manage picklists and picklist options for use with HTML select form element.

## [Search](/docs/developer-plugins-search)
The Search plugin allows you to make any kind of data searchable, enabling you to implement a robust searching rapidly.

## [SEO](/docs/developer-plugins-seo)
The goal of the SEO plug-in is to support search engine optimization (SEO) best practices without the content producer
needing to think about it.

## [Tags](/docs/developer-plugins-tags)
Provides a simple mechanism for tagging anything in the database. 