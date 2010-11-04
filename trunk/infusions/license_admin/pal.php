<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: pal.php
| Author: PHP-Fusion Addons Team
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
require_once "../../maincore.php";
require_once THEMES."templates/header.php";

//include INFUSIONS."license_admin/infusion_db.php";

if (file_exists(INFUSIONS."license_admin/locale/".$settings['locale'].".php")) {
	include INFUSIONS."license_admin/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."license_admin/locale/English.php";
}
add_to_title($locale['global_200'].$locale['pla_001'].$locale['global_200'].$locale['pla_105']);

opentable($locale['pla_106']);

echo "
PLEASE READ THE TERMS AND CONDITIONS OF THIS PROPRIETARY ADDON LICENSE CAREFULLY. BY EXERCISING ANY OF THE RIGHTS GRANTED BY THIS LICENSE YOU ARE DEEMED TO FULLY ACCEPT TERMS AND CONDITIONS OF THIS LICENSE. IF YOU DO NOT AGREE TO ALL OF THE TERMS AND CONDITIONS OF THIS LICENSE, YOU MAY NOT AVAIL OF ANY OF THE RIGHTS GRANTED BY THE LICENSE<br />\n<br />\n

<b>PREAMBLE:</b><br />\n<br />\n

PHP-Fusion Addon License, PAL (v1.0), is a License that cannot be bought, nor is it sold, it can only be obtained by applying for the right to use it, since this License also serves as a quality control instrument for, and by PHP-Fusion, as a motivator for PHP-Fusion Addon Developers and as a general Addon originality enhancer. This agreement is null and void if any part of this text is modified.<br />\n<br />\n

PHP-Fusion will not be held accountable for the products sold under this License, we do however use this License as a measure when we approve of any submitted Addon and PHP-Fusion state that any addon who is released under this License, PAL, at the time for it's approval was coded in accordance with PHP-Fusion coding standards, that PHP-Fusion deems Your Addon to be of such a high standard and originality that we allow You to use this License in conjunction with the Enduser PHP-Fusion Addon License, EPAL, v 1.0. This also gives You the right to use any logos provided by PHP-Fusion and none other, for public display and for marketing purposes.<br />\n<br />\n

PHP-Fusion is not responsible in any way for errors caused by You upgrading or updating Your work, this License is based on the specific code made by You upon application for this license, PHP-Fusion is not responsible for any measures, changes, alterations, additions or upgrades except where such upgrading is for security purposes only. You take with Your code after our approval. Hence it must be stated visible what version of Your Addon this License is valid for, if You undertake changes to the code.<br />\n<br />\n

PHP-Fusion shall be kept notified, and in the case You make a major upgrade, You must apply again with Your updated code. This is not necessary for changes to Your code based on security upgrades.<br />\n<br />\n

This part of the License is between You and PHP-Fusion. PHP-Fusion will provide a License for You to use with Your customers. You must use that License in order for this License to be valid. The text of that License, Enduser PHP-Fusion Addon License, EPAL (v1.0), is the enduser License which You must License Your software under and that is the License You accept to use for interacting with Your customers.<br />\n<br />\n


This PHP-Fusion Addon License, PAL (v1.0), is made between PHP-Fusion, copyright Nick Jones, Wrexham, Wales and (Addon Developers name here), that operates under this license:<br />\n<br />\n


<b>1. DEFINITIONS</b><br />\n<br />\n

1.1 Addon: A 3rd Party software addon that is based on PHP-Fusion and interacts with PHP-Fusion. An Addon is any piece of code that requires PHP-Fusion to run, display, execute or make any other use of Your Addon in combination with PHP-Fusion. This License may also be used by the Staff and Developers of PHP-Fusion, on same terms as for everyone else.<br />\n<br />\n

1.2 PHP-Fusion Trademarks: Any and all trademarks that PHP-Fusion owns or licenses, including, but not limited to, \"PHP-Fusion\", and PHP-Fusion logotypes.<br />\n<br />\n

1.3 Intellectual Property: All present and future copyrights, trademark rights, service mark rights, trade secret rights, patent rights, moral rights, and other intellectual property and proprietary rights recognized in any jurisdiction.<br />\n<br />\n

1.4 License: This entire agreement.<br />\n<br />\n

1.5 Licensed Materials: Any or all software, documentation or other work licensed under this License.<br />\n<br />\n

1.6 Territory: Worldwide, unless otherwise specified.<br />\n<br />\n

1.7 Other terms are defined throughout this License.<br />\n<br />\n

<b>2. TERM</b><br />\n<br />\n

The License agreement comes into effect on the date of license grant stated on PHP-Fusion answering Your application form. The License terminates when any of the relevant conditions of use within this License are no longer being met.

<b>3. LICENSE GRANT</b><br />\n<br />\n

Subject to the terms and conditions of this License, PHP-Fusion grants You a limited, non-exclusive, non-transferable and non sub-licensable license within the Territory to distribute PHP-Fusion Addon(s) which You yourself has produced. You, the Licensor, has the right to charge any amount You deem fit and suitable for Your product.You may also choose to let another party act on Your behalf as a reseller of Your Addon.<br />\n<br />\n

<b>4. EXCLUSIONS FROM LICENSE GRANT</b><br />\n<br />\n

PHP-Fusion reserves all rights not explicitly granted by this License. Except as specifically granted in this License, no rights are granted to any Intellectual Property owned by PHP-Fusion or any third party supplier. Nothing in this License shall be interpreted to prohibit PHP-Fusion from licensing any rights under terms and conditions that differ from the terms and conditions of this License.<br />\n<br />\n

<b>5. RESTRICTIONS</b><br />\n<br />\n

Rights granted to You by this License may only be exercised by You in accordance with the terms and conditions of this License. You may not change, hide or remove any proprietary rights notices, including but not limited to notices of copyright, License and warranty, which appear in the Licensed Materials or the License.<br />\n<br />\n

<b>6. NO SUPPORT</b><br />\n<br />\n

Except as expressly set in a separate written agreement, You are solely responsible for the entire installation, supervision, training, management, support, maintenance and control of the Licensed Materials and Your PHP-Fusion Addons, including all responsibility for installation and for maintenance of hardware and proper machine configuration.<br />\n<br />\n

<b>7. LICENSE FEES, PAYMENT AND TAXES</b><br />\n<br />\n
You have the right to charge any amount you deem fit for your Addon. All payments must be made in a currency accepted by You. You reserves the right to not accept any order. You are responsible for paying all taxes, levies and duties payable in connection with this License, other than taxes based upon PHP-Fusions income. You may not exercise any of the rights granted in this License if You are delinquent in your payments.<br />\n<br />\n

<b>8. CONFIDENTIAL INFORMATION</b><br />\n<br />\n

Neither party shall disclose confidential information to the other.<br />\n<br />\n

<b>9. TERMINATION</b><br />\n<br />\n

PHP-Fusion may terminate this License immediately if You breach any of the provisions of this License. In the event that You become liquidated, dissolved, bankrupt or insolvent, whether voluntarily or involuntarily, or shall take any action to be so declared, PHP-Fusion shall have the right to terminate this License immediately.<br />\n<br />\n

<b>10. TERMINATION FOR PATENT ACTION</b><br />\n<br />\n

This License shall terminate automatically and You may no longer exercise any of the rights granted to You by this License as of the date You commence an action, including a cross-claim or counterclaim, against PHP-Fusion, any third party supplier or other licensee alleging that the Licensed Software infringes a patent.<br />\n<br />\n

<b>11. BINDING</b><br />\n<br />\n

This License binds the parties, their respective successors and permitted assigns. There are no intended third party beneficiaries. Without the prior written consent of PHP-Fusion, You shall not assign or otherwise transfer this License or Your rights or obligations under this License to any person or party, whether by operation of law or otherwise. Any attempt by You to do so shall be null and void and be deemed a material breach of this License. The parties are, and shall remain, independent contractors; nothing in this License is designed to create, nor shall create between them, a partnership, joint venture, agency, or employment relationship.<br />\n<br />\n

<b>12. INDEMNIFICATION</b><br />\n<br />\n

You indemnify and agree to defend PHP-Fusion against any and all damages, judgments and costs (including reasonable attorneys' fees) related to any claim based upon: (a) use of the Licensed Software in a manner prohibited under this License or in a manner for which the Licensed Software was not designed; (b) changes made by You to the Licensed Software (where use of unmodified Licensed Software would not infringe);or (c) changes made, or actions taken, by PHP-Fusion upon Your direct instructions.<br />\n<br />\n

<b>13. LIMITATION OF LIABILITY AND REMEDIES</b><br />\n<br />\n

TO THE EXTENT PERMITTED BY APPLICABLE LAW, PHP-Fusion SHALL HAVE NO LIABILITY WITH RESPECT TO ITS OBLIGATIONS UNDER THIS AGREEMENT OR OTHERWISE FOR CONSEQUENTIAL, EXEMPLARY, SPECIAL, INDIRECT, INCIDENTAL OR PUNITIVE DAMAGES, INCLUDING (WITHOUT LIMITATION) ANY LOST PROFITS OR LOST SAVINGS (WHETHER RESULTING FROM IMPAIRED OR LOST DATA, SOFTWARE OR COMPUTER FAILURE OR ANY OTHER CAUSE), EVEN IF IT HAS BEEN ADVISED OF, HAS REASON TO KNOW OR IN FACT KNOWS OF, THE POSSIBILITY OF SUCH DAMAGES. THIS LIMITATION APPLIES TO ALL CAUSES OF ACTION IN THE AGGREGATE, INCLUDING (WITHOUT LIMITATION) BREACH OF CONTRACT, BREACH OF CONDITION AND WARRANTY, NEGLIGENCE, MISREPRESENTATIONS, TORTS AND
DELICTS, WHETHER ARISING UNDER STATUTE OR JURISPRUDENCE. TO THE EXTENT PERMITTED BY APPLICABLE LAW, NO ACTION, REGARDLESS OF FORM, ARISING OUT OF THIS AGREEMENT MAY BE BROUGHT BY YOU MORE THAN ONE YEAR AFTER THE CAUSE OF ACTION HAS OCCURRED. THE PARTIES AGREE THAT THE DISCLAIMERS AND LIMITATIONS OF LIABILITY AND REMEDIES HEREIN (A) ARE SEPARATELY INTENDED TO LIMIT THE FORMS AND CONTENT OF RELIEF AVAILABLE TO THE PARTIES AND (B) REFLECT AN INFORMED, VOLUNTARY ALLOCATION BETWEEN THEM OF ALL RISK (KNOWN AND UNKNOWN) ASSOCIATED WITH THE LICENSED SOFTWARE.<br />\n<br />\n

<b>14. DISPUTE RESOLUTION; GOVERNING LAW</b><br />\n<br />\n

In the case of any dispute, controversy or claim arising under, out of or relating to this License and any subsequent amendments thereto, including, without limitation, its formation, validity, binding effect, interpretation, performance, breach or termination, as well as non-contractual claims (\"Dispute\"), parties shall first attempt to resolve the Dispute through good faith discussions. If a Dispute cannot be resolved amicably between the parties, such Dispute shall be referred to and finally determined by arbitration in accordance with the WIPO Expedited Arbitration Rules. The place of arbitration shall be Geneva, Switzerland. The language to be used in the arbitral proceedings shall be English. The dispute, controversy or claim shall be decided in accordance with the law of Great Britain, without regard to the conflict of laws provisions thereof. In no event shall the United Nations Convention on Contracts for the International Sale of Goods or any adopted version of the United States Uniform Computer Information Transactions Act apply to, or govern, this License. Notwithstanding the foregoing, PHP-Fusion may seek injunctive or other equitable relief in any jurisdiction to protect its intellectual property rights. This section shall survive the termination of this License.<br />\n<br />\n


<b>15. NO WAIVER</b><br />\n<br />\n

Failure by PHP-Fusion to exercise any right or remedy does not signify acceptance of the event giving rise to such right or remedy.<br />\n<br />\n


<b>16. EXPORT LAW ASSURANCES</b><br />\n<br />\n

You shall comply (at Your expense) with all relevant and applicable laws, (including export and import regulations) related to use of the Licensed Software.<br />\n<br />\n

<b>17. ENGLISH LANGUAGE AGREEMENT</b><br />\n<br />\n

The parties have agreed to execute this License in the English language, and the English language version of the License will control for all purposes.<br />\n<br />\n


<b>18. US GOVERNMENT RESTRICTED RIGHTS</b><br />\n<br />\n

If the Licensed Software is being acquired by or on behalf of the U.S. Government or by a U.S. Government prime contractor or subcontractor (atany tier), in accordance with 48 C.F.R. 227.7202.-4 (for Department of Defense (\"DOD\") acquisitions) and 48 C.F.R. 2.101 and 13.212 (for non-DOD acquisitions), the government's rights in the Licensed Materials, including its rights to use, modify, reproduce, release, perform, display or disclose the Licensed Materials will be subject in all respects to the commercial rights and restrictions provided in this License.<br />\n<br />\n

<b>19. MISCELLANEOUS</b><br />\n<br />\n

If any provision of this License is held by a court of competent jurisdiction to be unenforceable, such provision shall be reformed only to the extent necessary to make it enforceable.<br />\n<br />\n

<b>20. ENTIRE LICENSE</b><br />\n<br />\n

This License comprises the entire agreement, and replaces and merges all prior proposals, understandings and agreements, oral and written, between the parties relating to the subject matter of this License. This License may be amended or modified only in a writing executed by both parties. To the extent of any conflict or inconsistency between this License or other document submitted by You to PHP-Fusion,
this License will control. PHP-Fusion's acceptance of any document shall not be construed as an acceptance of provisions which are in any way in conflict or inconsistent with, or in addition to, this License, unless such terms are separately and specifically accepted in writing by an authorized officer of PHP-Fusion.<br />\n<br />\n

";

echo "<br />\n";
include INFUSIONS."license_admin/footer_include.php";

closetable();

require_once THEMES."templates/footer.php";
?>