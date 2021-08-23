OC.L10N.register(
    "user_ldap",
    {
    "The Base DN appears to be wrong" : "ベース DN が誤っている可能性があります",
    "Testing configuration…" : "設定検証中…",
    "Configuration incorrect" : "設定に誤りがあります",
    "Configuration incomplete" : "設定が不完全です",
    "Configuration OK" : "設定OK",
    "Select groups" : "グループを選択",
    "Select object classes" : "オブジェクトクラスを選択",
    "Please check the credentials, they seem to be wrong." : "資格情報が間違っていると思われるため、確認してください。",
    "Please specify the port, it could not be auto-detected." : "ポートを指定してください。自動認識できません。",
    "Base DN could not be auto-detected, please revise credentials, host and port." : "ベース DN を自動検出できませんでした。資格情報、ホスト、ポートを修正してください。",
    "Could not detect Base DN, please enter it manually." : "ベース DN を検出できませんでした。手動で入力してください。",
    "{nthServer}. Server" : "{nthServer}. サーバー",
    "No object found in the given Base DN. Please revise." : "指定されたベース DN でオブジェクトを見つけることができませんでした。修正をお願いします。",
    "More than 1,000 directory entries available." : "1,000以上のディレクトリエントリが利用可能です。",
    " entries available within the provided Base DN" : "入力されたベースDNでエントリーが利用可能",
    "An error occurred. Please check the Base DN, as well as connection settings and credentials." : "エラーが発生しました。ベースDNをチェックし、接続設定と権限についても同様に確認してください。",
    "Do you really want to delete the current Server Configuration?" : "現在のサーバー設定を本当に削除してもよろしいですか？",
    "Confirm Deletion" : "削除の確認",
    "Mappings cleared successfully!" : "マッピングのクリアに成功しました！",
    "Error while clearing the mappings." : "マッピングのクリアー中にエラー発生",
    "Anonymous bind is not allowed. Please provide a User DN and Password." : "匿名接続が許可されていません。ユーザーDNとパスワードを入力してください。",
    "LDAP Operations error. Anonymous bind might not be allowed." : "LDAP操作エラー。匿名接続が許可されていないのかもしれません。",
    "Saving failed. Please make sure the database is in Operation. Reload before continuing." : "保存に失敗。データベースが稼働中か確認してください。続ける前にリロードしてください。",
    "Switching the mode will enable automatic LDAP queries. Depending on your LDAP size they may take a while. Do you still want to switch the mode?" : "モード切替により自動LDAP問合せが有効になります。LDAPのデータ量により時間がかかる可能性があります。モードを切り替えますか？",
    "Mode switch" : "モード変更",
    "Select attributes" : "属性を選択",
    "User not found. Please check your login attributes and username. Effective filter (to copy-and-paste for command line validation): <br/>" : "ユーザーは見つかりませんでした。ログインの属性とユーザー名をチェックしてください。適用されているフィルター(コピーペーストしてコマンドラインでの確認できます): <br/>",
    "User found and settings verified." : "ユーザーが見つかり、設定が検証できました。",
    "Settings verified, but more than one user was found. Only the first will be able to login. Consider a more narrow filter." : "設定は検証できましたが、ユーザーが1名以上見つかりました。最初の1名だけログインできます。より厳しいフィルターを検討してください。",
    "An unspecified error occurred. Please check the settings and the log." : "不明なエラーが発生しました。設定とログを確認してください。",
    "The search filter is invalid, probably due to syntax issues like uneven number of opened and closed brackets. Please revise." : "検索フィルターが不正です。恐らく文法の問題で、開き括弧と閉じ括弧がマッチしていません。修正をお願いします。",
    "A connection error to LDAP / AD occurred, please check host, port and credentials." : "LDAP / AD の接続エラーが発生しました。ホスト名、ポート、権限をチェックしてください。",
    "The %uid placeholder is missing. It will be replaced with the login name when querying LDAP / AD." : "%uid のプレースホルダがありません。LDAP / ADで問合せする際にプレースホルダはログイン名に置き換えられます。",
    "Please provide a login name to test against" : "テストの為にログイン名を入力してください。",
    "The group box was disabled, because the LDAP / AD server does not support memberOf." : "グループボックスは無効にされました。LDAP/AD サーバーが MemberOf オプションをサポートしていないからです。",
    "Server" : "サーバー",
    "Users" : "ユーザー",
    "Login Attributes" : "ログイン属性",
    "Groups" : "グループ",
    "The configuration is invalid: anonymous bind is not allowed." : "設定は無効です: 匿名接続は、許可されていません。",
    "The configuration is valid and the connection could be established!" : "設定は有効です。接続できました。",
    "The configuration is valid, but the Bind failed. Please check the server settings and credentials." : "設定は有効ですが、接続に失敗しました。サーバー設定と資格情報を確認してください。",
    "The configuration is invalid. Please have a look at the logs for further details." : "設定が無効です。詳細はログを確認してください。",
    "Failed to delete the server configuration" : "サーバー設定の削除に失敗しました",
    "Failed to clear the mappings." : "マッピングのクリアに失敗しました。",
    "No data specified" : "データが指定されていません",
    " Could not set configuration %s" : "構成 %s を設定できませんでした",
    "Action does not exist" : "アクションが存在しません",
    "_%s group found_::_%s groups found_" : ["%s グループが見つかりました"],
    "_%s user found_::_%s users found_" : ["%s ユーザーが見つかりました"],
    "Could not detect user display name attribute. Please specify it yourself in advanced ldap settings." : "ユーザー表示名の属性を検出できませんでした。詳細設定で対応する属性を指定してください。",
    "Could not find the desired feature" : "望ましい機能は見つかりませんでした",
    "Test Configuration" : "設定をテスト",
    "Groups meeting these criteria are available in %s:" : "これらの基準を満たすグループが %s で利用可能:",
    "Only these object classes:" : "このオブジェクトクラスからのみ:",
    "Only from these groups:" : "これらのグループからのみ:",
    "Search groups" : "グループを検索",
    "Available groups" : "利用可能なグループ",
    "Selected groups" : "選択されたグループ",
    "Edit LDAP Query" : "LDAPクエリの編集",
    "LDAP Filter:" : "LDAP フィルタ：",
    "The filter specifies which LDAP groups shall have access to the %s instance." : "フィルターは、どの LDAP グループが %s にアクセスするかを指定します。",
    "Verify settings and count groups" : "設定を検証し、グループを数える",
    "When logging in, %s will find the user based on the following attributes:" : "ログイン時に、%s  により次の属性からユーザーを見つけます:",
    "LDAP / AD Username:" : "LDAP/ADユーザー名:",
    "Allows login against the LDAP / AD username, which is either uid or samaccountname and will be detected." : "LDAP / AD ユーザー名に対してログインが許可されています。uid か、samaccountname のどちらかが検出されました。",
    "LDAP / AD Email Address:" : "LDAP / AD メールアドレス:",
    "Other Attributes:" : "その他の属性:",
    "Defines the filter to apply, when login is attempted. %%uid replaces the username in the login action. Example: \"uid=%%uid\"" : "ログイン実行時に適用するフィルターを定義します。%%uid にはログイン操作におけるユーザー名が入ります。例： \"uid=%%uid\"",
    "Test Loginname" : "テスト用ログイン名",
    "Verify settings" : "設定のチェック",
    "1. Server" : "1. Server",
    "%s. Server:" : "%s. サーバー:",
    "Add a new and blank configuration" : "空欄の新しい設定を追加",
    "Copy current configuration into new directory binding" : "現在の設定を新しいディレクトリ設定にコピー",
    "Delete the current configuration" : "現在の設定を削除",
    "Host" : "ホスト",
    "Port" : "ポート",
    "You can omit the protocol, except you require SSL. Then start with ldaps://" : "SSL通信しない場合には、プロトコル名を省略することができます。そうでない場合には、ldaps:// から始めてください。",
    "User DN" : "ユーザーDN",
    "The DN of the client user with which the bind shall be done, e.g. uid=agent,dc=example,dc=com. For anonymous access, leave DN and Password empty." : "どのクライアントユーザーのDNで接続するか指定します。例えば uid=agent,dc=example,dc=com になります。匿名アクセスの場合、DNとパスワードは空のままにしてください。",
    "Password" : "パスワード",
    "For anonymous access, leave DN and Password empty." : "匿名アクセスの場合は、DNとパスワードを空のままにしてください。",
    "One Base DN per line" : "1行に1つのベースDNを記入",
    "You can specify Base DN for users and groups in the Advanced tab" : "詳細設定でユーザーとグループのベースDNを指定することができます。",
    "Detect Base DN" : "ベース DN を検出",
    "Test Base DN" : "ベースDN をテスト",
    "Manually enter LDAP filters (recommended for large directories)" : "手動でLDAPフィルターを入力(大規模ディレクトリ時のみ推奨)",
    "Avoids automatic LDAP requests. Better for bigger setups, but requires some LDAP knowledge." : "自動的なLDAP問合せを停止します。大規模な設定には適していますが、LDAPの知識が必要になります。",
    "%s access is limited to users meeting these criteria:" : "%s のアクセス権は基準を満たすユーザーに制限されます:",
    "The most common object classes for users are organizationalPerson, person, user, and inetOrgPerson. If you are not sure which object class to select, please consult your directory admin." : "ユーザーの最も一般的なオブジェクトクラスは、organizationalPerson, person, user と inetOrgPerson です。もし、どのオブジェクトを選択すれば良いか分からない場合は、ディレクトリ管理者に相談してください。",
    "The filter specifies which LDAP users shall have access to the %s instance." : "フィルターは、どのLDAPユーザーが %s にアクセスするかを指定します。",
    "Verify settings and count users" : "設定を検証し、ユーザーを数える",
    "Saving" : "保存中",
    "Back" : "戻る",
    "Continue" : "続ける",
    "LDAP" : "LDAP",
    "Advanced" : "詳細設定",
    "Expert" : "エキスパート設定",
    "Help" : "ヘルプ",
    "<b>Warning:</b> Apps user_ldap and user_webdavauth are incompatible. You may experience unexpected behavior. Please ask your system administrator to disable one of them." : "<b>警告:</b> user_ldap と user_webdavauth のアプリには互換性がありません。予期せぬ動作をする可能性があります。システム管理者にどちらかを無効にするよう問い合わせてください。",
    "<b>Warning:</b> The PHP LDAP module is not installed, the backend will not work. Please ask your system administrator to install it." : "<b>警告:</b> PHP LDAP モジュールがインストールされていません。バックエンド接続が正しく動作しません。システム管理者にインストールするよう問い合わせてください。",
    "Connection Settings" : "接続設定",
    "When unchecked, this configuration will be skipped." : "チェックを外すと、この設定はスキップされます。",
    "Configuration Active" : "設定は有効です",
    "Backup (Replica) Host" : "バックアップ（レプリカ）ホスト",
    "Give an optional backup host. It must be a replica of the main LDAP/AD server." : "バックアップホストをオプションで指定することができます。メインのLDAP/ADサーバーのレプリカである必要があります。",
    "Backup (Replica) Port" : "バックアップ（レプリカ）ポート",
    "Disable Main Server" : "メインサーバーを無効にする",
    "Only connect to the replica server." : "レプリカサーバーにのみ接続します。",
    "Turn off SSL certificate validation." : "SSL証明書の確認を無効にする。",
    "Not recommended, use it for testing only! If connection only works with this option, import the LDAP server's SSL certificate in your %s server." : "推奨されません、テストにおいてのみ使用してください！このオプションでのみ接続が動作する場合は、LDAP サーバーのSSL証明書を %s サーバーにインポートしてください。",
    "Cache Time-To-Live" : "キャッシュのTTL",
    "in seconds. A change empties the cache." : "秒。変更後にキャッシュがクリアされます。",
    "Network Timeout" : "ネットワークタイムアウト",
    "Directory Settings" : "ディレクトリ設定",
    "User Display Name Field" : "ユーザー表示名のフィールド",
    "The LDAP attribute to use to generate the user's display name." : "ユーザーの表示名の生成に利用するLDAP属性",
    "2nd User Display Name Field" : "第2ユーザー表示名のフィールド",
    "Optional. An LDAP attribute to be added to the display name in brackets. Results in e.g. »John Doe (john.doe@example.org)«." : "オプションです。表示名内にカッコ付きで追加表示される属性　例：»John Doe (john.doe@example.org)«.",
    "Base User Tree" : "ベースユーザーツリー",
    "One User Base DN per line" : "1行に1つのユーザーベースDN",
    "User Search Attributes" : "ユーザー検索属性",
    "Optional; one attribute per line" : "オプション：1行に1属性",
    "Each attribute value is truncated to 191 characters" : "各属性の値は191文字以降切り捨てられます。",
    "Group Display Name Field" : "グループ表示名のフィールド",
    "The LDAP attribute to use to generate the groups's display name." : "ユーザーのグループ表示名の生成に利用するLDAP属性",
    "Base Group Tree" : "ベースグループツリー",
    "One Group Base DN per line" : "1行に1つのグループベースDN",
    "Group Search Attributes" : "グループ検索属性",
    "Group-Member association" : "グループとメンバーの関連付け",
    "Dynamic Group Member URL" : "ダイナミックグループメンバーURL",
    "The LDAP attribute that on group objects contains an LDAP search URL that determines what objects belong to the group. (An empty setting disables dynamic group membership functionality.)" : "グループオブジェクト上のLDAP属性はグループに属するオブジェクトを決定するLDAP検索URLを含みます｡(空の設定はダイナミックグループメンバーシップが機能的に無効になります｡)",
    "Nested Groups" : "ネストされたグループ",
    "When switched on, groups that contain groups are supported. (Only works if the group member attribute contains DNs.)" : "オンにすると、グループを含むグループが有効になります。(グループメンバーの属性にDNが含まれる場合のみ利用できます。)",
    "Paging chunksize" : "ページ分割サイズ",
    "Chunksize used for paged LDAP searches that may return bulky results like user or group enumeration. (Setting it 0 disables paged LDAP searches in those situations.)" : "ページ分割サイズは、LDAP検索時にユーザーやグループのリスト一覧データを一括で返すデータ量を指定します。(設定が0の場合には、LDAP検索の分割転送は無効)",
    "Special Attributes" : "特殊属性",
    "Quota Field" : "クォータ属性",
    "Leave empty for user's default quota. Otherwise, specify an LDAP/AD attribute." : "空のままにするとユーザーのデフォルトクオータになります。もしくは、LDAPもしくはADの属性を指定してください。",
    "Quota Default" : "クォータのデフォルト",
    "Email Field" : "メール属性",
    "User Home Folder Naming Rule" : "ユーザーのホームフォルダー命名規則",
    "Leave empty for user name (default). Otherwise, specify an LDAP/AD attribute." : "ユーザー名を空のままにしてください（デフォルト）。もしくは、LDAPもしくはADの属性を指定してください。",
    "Internal Username" : "内部ユーザー名",
    "Internal Username Attribute:" : "内部ユーザー名属性:",
    "Override UUID detection" : "UUID検出を再定義する",
    "By default, the UUID attribute is automatically detected. The UUID attribute is used to doubtlessly identify LDAP users and groups. Also, the internal username will be created based on the UUID, if not specified otherwise above. You can override the setting and pass an attribute of your choice. You must make sure that the attribute of your choice can be fetched for both users and groups and it is unique. Leave it empty for default behavior. Changes will have effect only on newly mapped (added) LDAP users and groups." : "デフォルトでは、UUID 属性は自動的に検出されます。UUID属性は、LDAPユーザーとLDAPグループを間違いなく識別するために利用されます。また、もしこれを指定しない場合は、内部ユーザー名はUUIDに基づいて作成されます。この設定は再定義することができ、あなたの選択した属性を用いることができます。選択した属性がユーザーとグループの両方に対して適用でき、かつユニークであることを確認してください。空であればデフォルトの振る舞いとなります。変更は、新しくマッピング（追加）されたLDAPユーザーとLDAPグループに対してのみ有効となります。",
    "UUID Attribute for Users:" : "ユーザーのUUID属性:",
    "UUID Attribute for Groups:" : "グループの UUID 属性:",
    "Username-LDAP User Mapping" : "ユーザー名とLDAPユーザーのマッピング",
    "Usernames are used to store and assign (meta) data. In order to precisely identify and recognize users, each LDAP user will have an internal username. This requires a mapping from username to LDAP user. The created username is mapped to the UUID of the LDAP user. Additionally the DN is cached as well to reduce LDAP interaction, but it is not used for identification. If the DN changes, the changes will be found. The internal username is used all over. Clearing the mappings will have leftovers everywhere. Clearing the mappings is not configuration sensitive, it affects all LDAP configurations! Never clear the mappings in a production environment, only in a testing or experimental stage." : "ユーザー名は(メタ)データの保存と割り当てに使用されます。ユーザーを正確に識別して認識するために、個々のLDAPユーザーは内部ユーザ名を持っています。これは、ユーザー名からLDAPユーザーへのマッピングが必要であることを意味しています。この生成されたユーザー名は、LDAPユーザーのUUIDにマッピングされます。加えて、DNがLDAPとのインタラクションを削減するためにキャッシュされますが、識別には利用されません。DNが変わった場合は、変更が検出されます。内部ユーザー名は全体に亘って利用されます。マッピングをクリアすると、いたるところに使われないままの物が残るでしょう。マッピングのクリアは設定に敏感ではありませんが、すべてのLDAPの設定に影響を与えます！本番の環境では決してマッピングをクリアしないでください。テストもしくは実験の段階でのみマッピングのクリアを行なってください。",
    "Clear Username-LDAP User Mapping" : "ユーザー名とLDAPユーザーのマッピングをクリアする",
    "Clear Groupname-LDAP Group Mapping" : "グループ名とLDAPグループのマッピングをクリアする"
},
"nplurals=1; plural=0;");
