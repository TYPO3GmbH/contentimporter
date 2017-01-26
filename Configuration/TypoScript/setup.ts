
# Module configuration
module.tx_contentimporter_web_contentimportercontentimport {
  persistence {
    storagePid = {$module.tx_contentimporter_contentimport.persistence.storagePid}
  }
  view {
    templateRootPaths.0 = EXT:contentimporter/Resources/Private/Backend/Templates/
    templateRootPaths.1 = {$module.tx_contentimporter_contentimport.view.templateRootPath}
    partialRootPaths.0 = EXT:contentimporter/Resources/Private/Backend/Partials/
    partialRootPaths.1 = {$module.tx_contentimporter_contentimport.view.partialRootPath}
    layoutRootPaths.0 = EXT:contentimporter/Resources/Private/Backend/Layouts/
    layoutRootPaths.1 = {$module.tx_contentimporter_contentimport.view.layoutRootPath}
  }
}
