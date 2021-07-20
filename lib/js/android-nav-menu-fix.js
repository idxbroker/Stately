// WP-823 -> Workaround for Android dropdown navigation menu behavior

document.addEventListener("DOMContentLoaded", function(event) {
    var userAgent = navigator.userAgent || navigator.vendor || window.opera;
    if (/android/i.test(userAgent)) {
        document.querySelectorAll('.menu-header-right .menu-item-has-children>a').forEach(function(element){
            element.setAttribute('data-original-href', element.getAttribute('href'))
            element.setAttribute('href', '#')
            element.onclick = function(){
                if (!element.classList.contains('expanded-parent-item')) {
                    wipeExpandedClasses()
                    element.classList.add('expanded-parent-item')
                } else {
                    window.location = element.getAttribute('data-original-href')
                }
            }
        })
    }
});

function wipeExpandedClasses() {
    document.querySelectorAll('.expanded-parent-item').forEach(function(element){element.classList.remove('expanded-parent-item')});
}