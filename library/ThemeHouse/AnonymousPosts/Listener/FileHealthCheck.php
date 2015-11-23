<?php

class ThemeHouse_AnonymousPosts_Listener_FileHealthCheck
{

    public static function fileHealthCheck(XenForo_ControllerAdmin_Abstract $controller, array &$hashes)
    {
        $hashes = array_merge($hashes,
            array(
                'library/ThemeHouse/AnonymousPosts/Extend/XenForo/ControllerPublic/FindNew.php' => '7bfa6aa5299e216123d7a00f73f3380e',
                'library/ThemeHouse/AnonymousPosts/Extend/XenForo/ControllerPublic/Forum.php' => '9919050eff02b769c6bcb4d9fd6fb182',
                'library/ThemeHouse/AnonymousPosts/Extend/XenForo/ControllerPublic/Member.php' => 'b04ce3067e51303751892d3e4adbd5c4',
                'library/ThemeHouse/AnonymousPosts/Extend/XenForo/ControllerPublic/RecentActivity.php' => '8d98488d3f9bb6d7189da28e6b2b3511',
                'library/ThemeHouse/AnonymousPosts/Extend/XenForo/ControllerPublic/Search.php' => '41186e16db1b2af3255fa4812c2195b7',
                'library/ThemeHouse/AnonymousPosts/Extend/XenForo/ControllerPublic/Thread.php' => '1bd4d64f4c2878964cc48b0ec9736643',
                'library/ThemeHouse/AnonymousPosts/Extend/XenForo/ControllerPublic/Watched.php' => '0187998488cc003fe35caaf69f38f5ad',
                'library/ThemeHouse/AnonymousPosts/Extend/XenForo/DataWriter/Discussion/Thread.php' => '4848556b3eaecbb8b77cc1eb1df5f0ab',
                'library/ThemeHouse/AnonymousPosts/Extend/XenForo/DataWriter/DiscussionMessage/Post.php' => '40ed12ff77b7d9a9d98d274f9dc4d40e',
                'library/ThemeHouse/AnonymousPosts/Extend/XenForo/Model/Forum.php' => '6a2eed80bbda326b60f3e61c4afe2b5d',
                'library/ThemeHouse/AnonymousPosts/Extend/XenForo/Model/Post.php' => 'fa4b5c40470f6c730debfaefbcde9a91',
                'library/ThemeHouse/AnonymousPosts/Extend/XenForo/Model/Thread.php' => 'd18fe42d85cbd728be4c47e5e1a43262',
                'library/ThemeHouse/AnonymousPosts/Install/Controller.php' => '72aeca8f8ec909b9c149aca8ac304615',
                'library/ThemeHouse/AnonymousPosts/Listener/LoadClass.php' => 'bc5817c6f088a4d96e8d860637250279',
                'library/ThemeHouse/AnonymousPosts/Listener/TemplatePostRender.php' => '3262f49ab79c145cfd024891c959dd5f',
                'library/ThemeHouse/Install.php' => '18f1441e00e3742460174ab197bec0b7',
                'library/ThemeHouse/Install/20151109.php' => '2e3f16d685652ea2fa82ba11b69204f4',
                'library/ThemeHouse/Deferred.php' => 'ebab3e432fe2f42520de0e36f7f45d88',
                'library/ThemeHouse/Deferred/20150106.php' => 'a311d9aa6f9a0412eeba878417ba7ede',
                'library/ThemeHouse/Listener/ControllerPreDispatch.php' => 'fdebb2d5347398d3974a6f27eb11a3cd',
                'library/ThemeHouse/Listener/ControllerPreDispatch/20150911.php' => 'f2aadc0bd188ad127e363f417b4d23a9',
                'library/ThemeHouse/Listener/InitDependencies.php' => '8f59aaa8ffe56231c4aa47cf2c65f2b0',
                'library/ThemeHouse/Listener/InitDependencies/20150212.php' => 'f04c9dc8fa289895c06c1bcba5d27293',
                'library/ThemeHouse/Listener/LoadClass.php' => '5cad77e1862641ddc2dd693b1aa68a50',
                'library/ThemeHouse/Listener/LoadClass/20150518.php' => 'f4d0d30ba5e5dc51cda07141c39939e3',
                'library/ThemeHouse/Listener/Template.php' => '0aa5e8aabb255d39cf01d671f9df0091',
                'library/ThemeHouse/Listener/Template/20150106.php' => '8d42b3b2d856af9e33b69a2ce1034442',
                'library/ThemeHouse/Listener/TemplatePostRender.php' => 'b6da98a55074e4cde833abf576bc7b5d',
                'library/ThemeHouse/Listener/TemplatePostRender/20150106.php' => 'efccbb2b2340656d1776af01c25d9382',
            ));
    }
}