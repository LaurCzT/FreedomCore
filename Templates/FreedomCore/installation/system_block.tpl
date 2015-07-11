<div class="section primary-section" id="sysreq">
    <br />
    <br />
    <div class="container">
        <div class="title">
            <h1>{#Installation_SysReq#}</h1>
            <p>{#Installation_SysReq_Desc#}</p>
        </div>
        <div class="row-fluid">
            <div class="span4">
                <div class="centered service">
                    <div class="circle-border zoom-in">
                        {if $Software.apache.verified}
                            <img class="img-circle" src="/Templates/{$Template}/images/installation/correct.png">
                        {else}
                            <img class="img-circle" src="/Templates/{$Template}/images/installation/incorrect.png">
                        {/if}
                    </div>
                    <h3>Apache 2.2.14</h3>
                    <p>{#Installation_SoftInstalled#}<br />{$Software.apache.version}</p>
                </div>
            </div>
            <div class="span4">
                <div class="centered service">
                    <div class="circle-border zoom-in">
                        {if $Software.php.verified}
                            <img class="img-circle" src="/Templates/{$Template}/images/installation/correct.png">
                        {else}
                            <img class="img-circle" src="/Templates/{$Template}/images/installation/incorrect.png">
                        {/if}
                    </div>
                    <h3>PHP 5.4.x</h3>
                    <p>{#Installation_SoftInstalled#}<br />{$Software.php.version}</p>
                </div>
            </div>
            <div class="span4">
                <div class="centered service">
                    <div class="circle-border zoom-in">
                        {if $Software.mysql.verified}
                            <img class="img-circle" src="/Templates/{$Template}/images/installation/correct.png">
                        {else}
                            <img class="img-circle" src="/Templates/{$Template}/images/installation/incorrect.png">
                        {/if}
                    </div>
                    <h3>MySQL 5.0.11</h3>
                    <p>{#Installation_SoftInstalled#}<br />{$Software.mysql.version}</p>
                </div>
            </div>
        </div>
    </div>
</div>